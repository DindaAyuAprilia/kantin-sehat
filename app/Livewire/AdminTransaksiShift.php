<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KasirTransaksi;
use App\Models\Shift;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class AdminTransaksiShift extends Component
{
    public $shifts;
    public $startDate;
    public $endDate;
    public $transaksis;
    public $nama_shift;
    public $jam_mulai;
    public $jam_selesai;
    public $selectedShiftId;
    public $activeTab = 'transaksi';
    public $isEditing = false;
    public $selectedId = null;
    public $isLoading = false;

    protected $listeners = [
        'editShift',
        'proceedUpdateShift',
        'deleteShift',
    ];

    protected $rules = [
        'nama_shift' => 'required|string|max:255',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ];

    public function mount()
    {
        $this->isLoading = true;
        $this->shifts = Shift::all();
        $this->startDate = Carbon::now()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
        $this->selectedShiftId = null;
        $this->updateTransaksis();
        $this->isLoading = false;
    }

    public function applyFilter()
    {
        $this->updateTransaksis();
    }

    public function updateTransaksis()
    {
        $query = KasirTransaksi::query()
            ->with(['user', 'details.barang.hasilBagi'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->selectedShiftId) {
            $query->where('shift_id', $this->selectedShiftId);
        }

        // Add search by unix_id
        if (!empty($this->search)) {
            $query->where('unix_id', 'like', '%' . $this->search . '%');
        }

        $this->transaksis = $query->get();
    }

    public function saveShift()
    {
        $this->isLoading = true;
        $this->validate();

        Shift::create([
            'nama_shift' => $this->nama_shift,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
        ]);

        $this->reset(['nama_shift', 'jam_mulai', 'jam_selesai', 'isEditing', 'selectedId']);
        $this->mount();
        $this->dispatch('swal:success', message: 'Shift berhasil ditambahkan.');
        $this->isLoading = false;
    }

    public function confirmEdit($id)
    {
        $this->dispatch('swal:confirmEditShift', id: $id);
    }

    public function editShift($id)
    {
        $this->isLoading = true;
        $this->selectedId = $id;
        $shift = Shift::find($this->selectedId);
        if ($shift) {
            $this->nama_shift = $shift->nama_shift;
            $this->jam_mulai = Carbon::parse($shift->jam_mulai)->format('H:i');
            $this->jam_selesai = Carbon::parse($shift->jam_selesai)->format('H:i');
            $this->isEditing = true;
        }
        $this->isLoading = false;
    }

    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdateShift');
    }

    public function proceedUpdateShift()
    {
        $this->isLoading = true;
        $this->validate();

        $shift = Shift::find($this->selectedId);
        if ($shift) {
            $shift->update([
                'nama_shift' => $this->nama_shift,
                'jam_mulai' => $this->jam_mulai,
                'jam_selesai' => $this->jam_selesai,
            ]);
        }

        $this->reset(['nama_shift', 'jam_mulai', 'jam_selesai', 'isEditing', 'selectedId']);
        $this->mount();
        $this->dispatch('swal:success', message: 'Shift berhasil diperbarui.');
        $this->isLoading = false;
    }

    public function confirmDelete($id)
    {
        $shift = Shift::find($id);
        if ($shift && $shift->transaksis()->count() > 0) {
            $this->dispatch('swal:error', message: 'Shift tidak dapat dihapus karena masih terkait dengan transaksi.');
            return;
        }
        $this->dispatch('swal:confirmDeleteShift', id: $id);
    }

    public function deleteShift($id)
    {
        $this->isLoading = true;
        $shift = Shift::find($id);
        if ($shift) {
            $shift->delete();
            $this->reset(['selectedId']);
            $this->mount();
            $this->dispatch('swal:success', message: 'Shift berhasil dihapus.');
        }
        $this->isLoading = false;
    }

    public function viewShiftReport()
    {
        $this->isLoading = true;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $htmlContent = $this->generateShiftReportHtml($startDate, $endDate, $this->selectedShiftId);

        $reportKey = 'report_shift_' . now()->format('YmdHis');
        Session::put($reportKey, $htmlContent);

        $this->redirect(route('report.view', ['key' => $reportKey]), navigate: false);
        $this->isLoading = false;
    }

    private function generateShiftReportHtml($startDate, $endDate, $shiftId)
    {
        $details = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate, $shiftId) {
            $query->whereBetween('tanggal', [$startDate, $endDate])
                  ->when($shiftId, function ($q) use ($shiftId) {
                      $q->where('shift_id', $shiftId);
                  });
        })
        ->with(['transaksi', 'barang.hasilBagi'])
        ->get();

        $transaksis = KasirTransaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->when($shiftId, function ($q) use ($shiftId) {
                $q->where('shift_id', $shiftId);
            })
            ->get();

        $totalTransfer = 0;
        $totalTunai = 0;

        foreach ($transaksis as $transaksi) {
            $metodePembayaran = strtolower($transaksi->metode_pembayaran ?? 'tunai');
            $total = $transaksi->details->sum('subtotal');
            if (strpos($metodePembayaran, 'transfer') !== false) {
                $totalTransfer += $total;
            } else {
                $totalTunai += $total;
            }
        }

        $groupedData = $details->groupBy(function ($detail) {
            return $detail->transaksi->tanggal . '|' . ($detail->barang ? $detail->barang->nama : 'Tidak Diketahui');
        });

        $reportData = collect();
        $totalKas = 0;
        $totalKasTitipan = 0;
        $totalKeuntunganTitipan = 0;
        $totalKeuntunganNonTitipan = 0;

        foreach ($groupedData as $key => $items) {
            list($date, $barangNama) = explode('|', $key);
            $totalJumlah = $items->sum('jumlah');
            $totalSubtotal = $items->sum('subtotal');

            $transaksi = $items->first()->transaksi;
            $metodePembayaran = strtolower($transaksi->metode_pembayaran ?? 'tunai');

            $barang = $items->first()->barang;
            $isTitipan = $barang ? $barang->status_titipan : false;
            $hargaPokok = $barang ? $barang->harga_pokok : 0;
            $totalHargaPokok = $totalJumlah * $hargaPokok;

            $keuntungan = 0;
            if ($isTitipan && $barang) {
                $roundingUnit = $barang->hasilBagi ? (int)$barang->hasilBagi->tipe : 1000;
                $keuntungan = $roundingUnit * $totalJumlah;
                $totalKas += $keuntungan;
                $totalKasTitipan += $totalHargaPokok;
                $totalKeuntunganTitipan += $keuntungan;
            } else {
                $keuntungan = $totalSubtotal - $totalHargaPokok;
                $totalKas += $totalSubtotal;
                $totalKeuntunganNonTitipan += $keuntungan;
            }

            $hargaSatuan = $totalJumlah > 0 ? $totalSubtotal / $totalJumlah : ($items->first()->harga_satuan ?? 0);
            $hargaPokokPerUnit = $totalJumlah > 0 ? $totalHargaPokok / $totalJumlah : $hargaPokok;
            $masukKas = $isTitipan ? $keuntungan : $totalSubtotal;
            $masukKasTitipan = $isTitipan ? $totalHargaPokok : 0;

            $reportData->push([
                'date' => $date,
                'barangNama' => $barangNama,
                'totalJumlah' => $totalJumlah,
                'totalSubtotal' => $totalSubtotal,
                'hargaSatuan' => $hargaSatuan,
                'isTitipan' => $isTitipan,
                'totalHargaPokok' => $totalHargaPokok,
                'keuntungan' => $keuntungan,
                'hargaPokokPerUnit' => $hargaPokokPerUnit,
                'masukKas' => $masukKas,
                'masukKasTitipan' => $masukKasTitipan,
                'metodePembayaran' => $metodePembayaran,
            ]);
        }

        $reportData = $reportData->sortBy('date');

        $summaryLines = [];
        $summaryLines[] = "<p><span class=\"label\">Total Masuk Kas:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalKas)}</span></p>";
        $summaryLines[] = "<p><span class=\"label\">Total Masuk Kas Titipan:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalKasTitipan)}</span></p>";
        if ($totalTransfer != 0) {
            $summaryLines[] = "<p><span class=\"label\">Total Transaksi Transfer:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalTransfer)}</span></p>";
        }
        if ($totalTunai != 0) {
            $summaryLines[] = "<p><span class=\"label\">Total Transaksi Tunai:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalTunai)}</span></p>";
        }
        if ($totalKeuntunganTitipan != 0) {
            $summaryLines[] = "<p><span class=\"label\">Total Keuntungan Barang Titipan:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalKeuntunganTitipan)}</span></p>";
        }
        if ($totalKeuntunganNonTitipan != 0) {
            $summaryLines[] = "<p><span class=\"label\">Total Keuntungan Barang Non-Titipan:</span> <span class=\"text-right\">Rp {$this->formatRupiah($totalKeuntunganNonTitipan)}</span></p>";
        }
        $summaryHtml = implode("\n", $summaryLines);

        $html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Shift</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding-left: 20px;
            padding-right: 20px;
            line-height: 1.4;
        }
        h1 {
            text-align: center;
            font-size: 1.2rem;
        }
        h2 {
            text-align: center;
            font-size: 1rem;
        }
        .report-container {
            overflow-x: auto;
            max-width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            text-align: left;
            font-size: 0.75rem;
        }
        th {
            background-color: #007022;
            color: white;
            font-weight: bold;
            padding: 0.4rem 0.8rem;
            border: 1px solid #007022;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        td {
            padding: 0.4rem 0.8rem;
            border: 1px solid #007022;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .summary {
            padding: 0.4rem 0.8rem;
            background-color: #f9f9f9;
            border: 1px solid #007022;
            border-radius: 4px;
            margin-top: 1rem;
            font-size: 0.75rem;
        }
        .summary p {
            margin: 0.2rem 0;
        }
        .summary .label {
            font-weight: bold;
            margin-right: 0.5rem;
            color: #007022;
        }
        @media print {
            body {
                margin: 0;
                padding-left: 20px;
                padding-right: 20px;
            }
            table {
                page-break-inside: auto;
            }
            thead {
                display: table-header-group;
            }
            tbody {
                display: table-row-group;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th {
                background-color: #007022 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }
            .summary {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <h1>Kantin Sehat UPT Pelayanan Kesehatan</h1>
    <h2>Laporan Penjualan Shift</h2>
    <p class="text-center">Periode: dari tanggal {$this->formatDate($startDate)} sampai dengan {$this->formatDate($endDate)}</p>
    <p class="text-center">Shift: {$this->getShiftName($shiftId)}</p>
    <div class="report-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Harga Pokok</th>
                    <th class="text-right">Jumlah Terjual</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Keuntungan</th>
                    <th class="text-right">Masuk Kas</th>
                    <th class="text-right">Masuk Kas Titipan</th>
                </tr>
            </thead>
            <tbody>
HTML;

        $counter = 1;
        $grandTotalSubtotal = 0;
        $grandTotalKeuntungan = 0;

        foreach ($reportData as $item) {
            $grandTotalSubtotal += $item['totalSubtotal'];
            $grandTotalKeuntungan += $item['keuntungan'];

            $html .= <<<HTML
        <tr>
            <td>{$counter}</td>
            <td>{$this->formatDate($item['date'])}</td>
            <td>{$item['barangNama']}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['hargaSatuan'])}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['hargaPokokPerUnit'])}</td>
            <td class="text-right">{$item['totalJumlah']}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['totalSubtotal'])}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['keuntungan'])}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['masukKas'])}</td>
            <td class="text-right">Rp {$this->formatRupiah($item['masukKasTitipan'])}</td>
        </tr>
HTML;
            $counter++;
        }

        $html .= <<<HTML
        <tr>
            <td colspan="6" class="text-right bold">Total</td>
            <td class="text-right bold">Rp {$this->formatRupiah($grandTotalSubtotal)}</td>
            <td class="text-right bold">Rp {$this->formatRupiah($grandTotalKeuntungan)}</td>
            <td class="text-right bold">Rp {$this->formatRupiah($totalKas)}</td>
            <td class="text-right bold">Rp {$this->formatRupiah($totalKasTitipan)}</td>
        </tr>
    </tbody>
</table>
    </div>
    <div class="summary mt-4">
        {$summaryHtml}
    </div>
</body>
</html>
HTML;

        return $html;
    }

    private function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function formatRupiah($value)
    {
        return number_format($value, 2, ',', '.');
    }

    private function getShiftName($shiftId)
    {
        if (!$shiftId) {
            return 'Semua Shift';
        }
        $shift = Shift::find($shiftId);
        return $shift ? $shift->nama_shift : 'Tidak Diketahui';
    }

    public function render()
    {
        return view('livewire.transaksi-shift');
    }
}