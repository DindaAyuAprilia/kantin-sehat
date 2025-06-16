<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KasirTransaksi;
use App\Models\Persediaan;
use App\Models\Barang;
use App\Models\Kas;
use App\Models\KasTitipan;
use App\Models\GajiPembayaran;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\SaldoKasBulanan;
use App\Models\SaldoBarangBulanan;
use App\Models\KasKerugian;
use App\Models\KasKembalian;
use App\Models\Pengeluaran;
use App\Models\KasKeuntungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $saldoKas;
    public $saldoKembalian;
    public $penjualanData;
    public $pembelianData;
    public $labels;
    public $selectedMonth;
    public $selectedPeriod = 'monthly';
    public $selectedYear;
    public $startDate;
    public $endDate;
    public $kasTitipans;
    public $selectedKasTitipanId;
    public $penguranganSaldo;
    public $isReducing = false;
    public $topSellingItems;
    public $highestProfitItems;
    public $leastSellingItems;
    public $topSellingLabels;
    public $topSellingData;
    public $highestProfitLabels;
    public $highestProfitData;
    public $leastSellingLabels;
    public $leastSellingData;

    public function mount(): void
    {
        $this->selectedMonth = now()->format('Y-m');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->loadAllData();
    }

    private function loadAllData(): void
    {
        $this->kasTitipans = KasTitipan::with('barang')->get();
        $this->loadSaldoKas();
        $this->loadSaldoKembalian();
        $this->loadChartData();
        $this->loadItemStatistics();
    }

    private function loadSaldoKas(): void
    {
        $periodeBulan = Carbon::parse($this->selectedMonth)->format('F Y');
        $saldoKasBulanan = SaldoKasBulanan::where('periode_bulan', $periodeBulan)->first();
        $this->saldoKas = $saldoKasBulanan ? ($saldoKasBulanan->saldo_akhir ?? $saldoKasBulanan->saldo_awal ?? 0) : 0;
    }

    private function loadSaldoKembalian(): void
    {
        $this->saldoKembalian = KasKembalian::sum('jumlah') ?? 0;
    }

    public function loadChartData(): void
    {
        if (!$this->selectedMonth && !$this->selectedYear) {
            $this->labels = ['Tidak Ada Data'];
            $this->penjualanData = [0];
            $this->pembelianData = [0];
            $this->dispatch('chart-updated');
            return;
        }

        if ($this->selectedPeriod === 'monthly') {
            $start = Carbon::parse($this->selectedMonth)->startOfMonth();
            $end = Carbon::parse($this->selectedMonth)->endOfMonth();
        } else {
            $start = Carbon::create($this->selectedYear)->startOfYear();
            $end = Carbon::create($this->selectedYear)->endOfYear();
        }

        $transaksis = KasirTransaksi::select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(total_harga) as total'))
            ->whereBetween('tanggal', [$start, $end])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $persediaans = Persediaan::select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(total_harga) as total'))
            ->where('tipe', 'penambahan')
            ->whereBetween('tanggal', [$start, $end])
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $this->labels = [];
        $this->penjualanData = [];
        $this->pembelianData = [];

        $dates = collect();
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        foreach ($dates as $date) {
            $this->labels[] = Carbon::parse($date)->format('d M');
            $penjualan = $transaksis->where('date', $date)->first()->total ?? 0;
            $pembelian = $persediaans->where('date', $date)->first()->total ?? 0;
            $this->penjualanData[] = $penjualan;
            $this->pembelianData[] = $pembelian;
        }

        $this->dispatch('chart-updated');
    }

    private function loadItemStatistics(): void
    {
        if ($this->selectedPeriod === 'monthly') {
            $start = Carbon::parse($this->selectedMonth)->startOfMonth();
            $end = Carbon::parse($this->selectedMonth)->endOfMonth();
        } else {
            $start = Carbon::create($this->selectedYear)->startOfYear();
            $end = Carbon::create($this->selectedYear)->endOfYear();
        }

        $this->topSellingItems = DetailTransaksi::select('barang_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereHas('transaksi', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->groupBy('barang_id')
            ->orderByDesc('total_jumlah')
            ->limit(5)
            ->with('barang')
            ->get();

        $this->highestProfitItems = DetailTransaksi::select('barang_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereHas('transaksi', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->groupBy('barang_id')
            ->with('barang')
            ->get()
            ->map(function ($item) use ($start, $end) {
                $penjualan = $item->total_jumlah * $item->barang->harga_jual;
                $biayaPokok = $this->calculateFifoCogs($item->barang_id, $item->total_jumlah, $start, $end);
                $laba = $penjualan - $biayaPokok;
                return [
                    'barang' => $item->barang,
                    'total_jumlah' => $item->total_jumlah,
                    'laba' => $laba,
                ];
            })
            ->sortByDesc('laba')
            ->take(5);

        $this->leastSellingItems = DetailTransaksi::select('barang_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereHas('transaksi', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->groupBy('barang_id')
            ->orderBy('total_jumlah')
            ->limit(5)
            ->with('barang')
            ->get();

        $this->topSellingLabels = $this->topSellingItems->pluck('barang.nama')->toArray();
        $this->topSellingData = $this->topSellingItems->pluck('total_jumlah')->toArray();
        $this->highestProfitLabels = $this->highestProfitItems->pluck('barang.nama')->toArray();
        $this->highestProfitData = $this->highestProfitItems->pluck('laba')->toArray();
        $this->leastSellingLabels = $this->leastSellingItems->pluck('barang.nama')->toArray();
        $this->leastSellingData = $this->leastSellingItems->pluck('total_jumlah')->toArray();
    }

    public function transferKembalianToKeuntungan()
    {
        /** @var \Illuminate\Contracts\Auth\Guard $guard */
        $guard = auth();
        /** @var \App\Models\User|null $user */
        $user = $guard->user();
        
        if ($this->saldoKembalian > 0 && $user) {
            KasKeuntungan::create([
                'user_id' => $user->id,
                'jumlah' => $this->saldoKembalian,
                'tanggal' => now(),
                'keterangan' => 'Transfer dari kas kembalian pada ' . now()->format('Y-m-d H:i:s')
            ]);

            // Reset saldo kembalian
            $this->saldoKembalian = 0;

            // Hapus semua data di tabel kas_kembalian
            KasKembalian::query()->delete();

            session()->flash('success', 'Saldo kembalian berhasil ditransfer ke keuntungan dan tabel kas kembalian direset.');
            $this->dispatch('refreshDashboard');
        }
    }

    private function calculateFifoCogs($barangId, $quantityNeeded, $startDate, $endDate): float
    {
        $persediaans = Persediaan::where('barang_id', $barangId)
            ->where('tipe', 'penambahan')
            ->where('sisa_stok', '>', 0)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalBiayaPokok = 0;

        foreach ($persediaans as $persediaan) {
            if ($quantityNeeded <= 0) {
                break;
            }

            $available = $persediaan->sisa_stok;
            $used = min($available, $quantityNeeded);
            $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
            $totalBiayaPokok += $used * $biayaPokokPerUnit;
            $quantityNeeded -= $used;
        }

        return $totalBiayaPokok;
    }

    public function checkPeriod()
    {
        if ($this->selectedPeriod === 'monthly') {
            $this->validate([
                'selectedMonth' => 'required|date_format:Y-m',
            ]);
            $this->loadChartData();
            $this->loadSaldoKas();
            $this->loadItemStatistics();
        } elseif ($this->selectedPeriod === 'yearly') {
            $this->validate([
                'selectedYear' => 'required|integer|min:2000|max:2100',
            ]);
            $this->loadChartData();
            $this->loadSaldoKas();
            $this->loadItemStatistics();
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['startDate', 'endDate'])) {
            $this->validate([
                'startDate' => 'required|date|before_or_equal:endDate',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);
        }
    }

    public function startReduceSaldo($id)
    {
        $this->selectedKasTitipanId = $id;
        $this->penguranganSaldo = '';
        $this->isReducing = true;
    }

    public function setMaxSaldo()
    {
        $kasTitipan = KasTitipan::find($this->selectedKasTitipanId);
        if ($kasTitipan) {
            $this->penguranganSaldo = $kasTitipan->saldo_kas;
        }
    }

    public function reduceSaldo()
    {
        $this->validate([
            'penguranganSaldo' => 'required|numeric|min:0',
        ]);

        $kasTitipan = KasTitipan::find($this->selectedKasTitipanId);
        if ($kasTitipan && $this->penguranganSaldo <= $kasTitipan->saldo_kas) {
            $kasTitipan->saldo_kas -= $this->penguranganSaldo;
            $kasTitipan->save();

            $this->kasTitipans = KasTitipan::with('barang')->get();
            $this->isReducing = false;
            $this->selectedKasTitipanId = null;
            $this->penguranganSaldo = '';
            session()->flash('success', 'Saldo kas titipan berhasil dikurangi.');
        } else {
            $this->addError('penguranganSaldo', 'Jumlah pengurangan melebihi saldo kas titipan.');
        }
    }

    public function cancelReduce()
    {
        $this->isReducing = false;
        $this->selectedKasTitipanId = null;
        $this->penguranganSaldo = '';
        $this->resetErrorBag();
    }

    public function viewReport($type)
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $htmlContent = $this->generateHtmlReport($type, $startDate, $endDate);

        $reportKey = 'report_' . $type . '_' . now()->format('YmdHis');
        Session::put($reportKey, $htmlContent);

        $this->dispatch('open-report', url: route('report.view', ['key' => $reportKey]));
        $this->loadAllData(); // Muat ulang data statistik
    }

    private function generateHtmlReport($type, $startDate, $endDate)
    {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$this->getReportTitle($type)}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding-left: 20px; padding-right: 20px; line-height: 1.4; }
        h1 { text-align: center; font-size: 1rem; color: black; }
        h2 { text-align: center; font-size: 0.9rem; color: black; }
        .text-center { text-align: center; }
        .report-container { overflow-x: auto; max-width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; text-align: left; font-size: 0.75rem; border: 1px solid #007022; }
        th { background-color: #007022; color: white; font-weight: bold; padding: 0.5rem 1rem; border: 1px solid #00551a; text-align: center; font-size: 0.9rem; text-transform: uppercase; }
        td { padding: 0.4rem 0.8rem; border: 1px solid #007022; text-align: left; }
        tr:nth-child(even) { background-color: #f5faf5; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .section-header { background-color: #dcedc8; font-weight: bold; border-top: 1px solid #007022; border-bottom: 1px solid #007022; }
        .subcategory { padding-left: 1.5rem; }
        .total-row { background-color: #dcedc8; font-weight: bold; }
        .highlight { background-color: #dcedc8; }
        .mt-4 { margin-top: 1rem; }
        .mb-4 { margin-bottom: 1rem; }
        @media print { body { margin: 0; padding-left: 20px; padding-right: 20px; } table { page-break-inside: auto; width: 100%; } @page portrait { size: A4 portrait; margin: 10mm; } @page landscape { size: A4 landscape; margin: 10mm; } @page { size: A4 portrait; } .report-container { overflow-x: visible; } table { max-width: none; } thead { display: table-header-group; } tbody { display: table-row-group; } tr { page-break-inside: avoid; page-break-after: auto; } th { background-color: #007022 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; color: white !important; border: 1px solid #00551a !important; } td { border: 1px solid #007022 !important; } .section-header { background-color: #dcedc8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; } .total-row { background-color: #dcedc8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; } .highlight { background-color: #dcedc8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; } tr:nth-child(even) { background-color: #f5faf5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
    </style>
    <script>window.onload = function() { window.print(); };</script>
</head>
<body>
    <h1>Kantin Sehat UPT Pelayanan Kesehatan</h1>
    <h2>{$this->getReportTitle($type)}</h2>
    <p class="text-center">Periode: dari tanggal {$this->formatDate($startDate)} sampai dengan {$this->formatDate($endDate)}</p>
    <div class="mt-4 mb-4">
HTML;

        if ($type === 'penerimaan_pembayaran') {
            $html .= $this->generatePenerimaanPembayaranHtml($startDate, $endDate);
        } elseif ($type === 'buku_besar') {
            $html .= $this->generateBukuBesarHtml($startDate, $endDate);
        } elseif ($type === 'nilai_persediaan') {
            $html .= $this->generateRingkasanNilaiPersediaanHtml($startDate, $endDate);
        } elseif ($type === 'margin_laba') {
            $html .= $this->generateMarginLabaHtml($startDate, $endDate);
        } elseif ($type === 'laba_rugi') {
            $html .= $this->generateLabaRugiHtml($startDate, $endDate);
        } elseif ($type === 'ringkasan_kuantitas') {
            $html .= $this->generateRingkasanKuantitasHtml($startDate, $endDate);
        } elseif ($type === 'laporan_tahunan') {
            $html .= $this->generateAnnualReportHtml($startDate, $endDate);
        } elseif ($type === 'kas_titipan') {
            $html .= $this->generateKasTitipanHtml($startDate, $endDate);
        }

        $html .= <<<HTML
    </div>
</body>
</html>
HTML;

        return $html;
    }

    private function generatePenerimaanPembayaranHtml($startDate, $endDate)
    {
        $bagiHasilByType = [];
        $details = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->with(['transaksi', 'barang.hasilBagi'])
        ->whereHas('barang', function ($query) {
            $query->where('status_titipan', true);
        })
        ->get();

        foreach ($details as $detail) {
            $barang = $detail->barang;
            if ($barang && $barang->status_titipan && $barang->hasilBagi) {
                $tipe = (int)$barang->hasilBagi->tipe;
                $bagiHasilByType[$tipe] = ($bagiHasilByType[$tipe] ?? 0) + ($tipe * $detail->jumlah);
            }
        }

        $pendapatanBagiHasil = array_sum($bagiHasilByType);
        $penjualanBarang = KasirTransaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('details.barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $keuntunganKas = KasKeuntungan::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPenerimaan = $pendapatanBagiHasil + $penjualanBarang + $keuntunganKas;

        $biayaGaji = GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->sum('jumlah');
        $kerugianPersediaan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'penghapusan')
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $persediaanDiTangan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'penambahan')
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $kerugianKas = KasKerugian::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');

        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->select('deskripsi', DB::raw('SUM(jumlah) as total'))
            ->groupBy('deskripsi')
            ->get();
        $totalPengeluaran = $pengeluarans->sum('total');

        $totalPembayaran = $biayaGaji + $kerugianPersediaan + $persediaanDiTangan + $kerugianKas + $totalPengeluaran;

        $tambahanBersih = $totalPenerimaan - $totalPembayaran;
        $saldoAwal = $this->getSaldoAwalKas($startDate);
        $saldoAkhir = $saldoAwal + $tambahanBersih;

        $html = <<<HTML
<div class="report-container">
    <table>
        <thead>
            <tr><th colspan="2">Penerimaan</th></tr>
            <tr><th>Kategori</th><th class="text-right">Jumlah</th></tr>
        </thead>
        <tbody>
            <tr class="section-header"><td colspan="2">Pendapatan Bagi Hasil (per Jenis)</td></tr>
HTML;
        foreach ($bagiHasilByType as $tipe => $jumlah) {
            $html .= <<<HTML
            <tr><td class="subcategory">Hasil Bagi {$tipe}</td><td class="text-right">Rp {$this->formatRupiah($jumlah)}</td></tr>
HTML;
        }
        $html .= <<<HTML
            <tr class="total-row"><td>Total Pendapatan Bagi Hasil</td><td class="text-right bold">Rp {$this->formatRupiah($pendapatanBagiHasil)}</td></tr>
            <tr><td>Penjualan Barang Dagang (Non-Titipan)</td><td class="text-right">Rp {$this->formatRupiah($penjualanBarang)}</td></tr>
            <tr><td>Keuntungan Kas</td><td class="text-right">Rp {$this->formatRupiah($keuntunganKas)}</td></tr>
            <tr class="total-row"><td>Total Penerimaan</td><td class="text-right bold">Rp {$this->formatRupiah($totalPenerimaan)}</td></tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr><th colspan="2">Pembayaran & Ringkasan</th></tr>
            <tr><th>Kategori</th><th class="text-right">Jumlah</th></tr>
        </thead>
        <tbody>
            <tr><td>Biaya Gaji Karyawan</td><td class="text-right">Rp {$this->formatRupiah($biayaGaji)}</td></tr>
            <tr><td>Kerugian Persediaan (Non-Titipan)</td><td class="text-right">Rp {$this->formatRupiah($kerugianPersediaan)}</td></tr>
            <tr><td>Persediaan di Tangan (Non-Titipan)</td><td class="text-right">Rp {$this->formatRupiah($persediaanDiTangan)}</td></tr>
            <tr><td>Kerugian Kas</td><td class="text-right">Rp {$this->formatRupiah($kerugianKas)}</td></tr>
HTML;
        foreach ($pengeluarans as $pengeluaran) {
            $html .= <<<HTML
            <tr><td>{$pengeluaran->deskripsi}</td><td class="text-right">Rp {$this->formatRupiah($pengeluaran->total)}</td></tr>
HTML;
        }
        $html .= <<<HTML
            <tr class="total-row"><td>Total Pembayaran</td><td class="text-right bold">Rp {$this->formatRupiah($totalPembayaran)}</td></tr>
            <tr class="highlight"><td>Tambahan (Pengurangan) Bersih pada Kas</td><td class="text-right">Rp {$this->formatRupiah($tambahanBersih)}</td></tr>
            <tr><td>Saldo Awal Kas</td><td class="text-right">Rp {$this->formatRupiah($saldoAwal)}</td></tr>
            <tr class="total-row"><td>Saldo Akhir Kas</td><td class="text-right bold">Rp {$this->formatRupiah($saldoAkhir)}</td></tr>
        </tbody>
    </table>
</div>
HTML;

        return $html;
    }

    private function generateRingkasanNilaiPersediaanHtml($startDate, $endDate)
    {
        $periodeBulan = Carbon::parse($startDate)->format('F Y');
        $saldoAwalData = SaldoBarangBulanan::with('barang')
            ->where('periode_bulan', $periodeBulan)
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->get();

        $totalSaldoAwal = 0;
        $totalPembelian = 0;
        $totalPenjualan = 0;
        $totalPenghapusan = 0;
        $totalSaldoAkhir = 0;

        $html = <<<HTML
<div class="report-container">
    <table>
        <thead>
            <tr>
                <th>Kode Barcode</th>
                <th>Nama</th>
                <th>Saldo Awal</th>
                <th>Pembelian</th>
                <th>Biaya Pokok Penjualan</th>
                <th>Penghapusan</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
HTML;

        foreach ($saldoAwalData as $saldo) {
            $barang = $saldo->barang;
            $kodeBarcode = $barang->kode_barang ?? 'N/A';
            $nama = $barang->nama ?? 'N/A';
            $saldoAwal = $saldo->nilai_kuantitas_awal ?? 0;

            $pembelian = Persediaan::where('barang_id', $barang->id)
                ->where('tipe', 'penambahan')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('total_harga');

            $jumlahTerjual = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->sum('jumlah');
            $penjualan = $this->calculateFifoCogs($barang->id, $jumlahTerjual, $startDate, $endDate);

            $penghapusan = Persediaan::where('barang_id', $barang->id)
                ->where('tipe', 'penghapusan')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('total_harga');
            $saldoAkhir = $saldoAwal + $pembelian - $penjualan - $penghapusan;

            $totalSaldoAwal += $saldoAwal;
            $totalPembelian += $pembelian;
            $totalPenjualan += $penjualan;
            $totalPenghapusan += $penghapusan;
            $totalSaldoAkhir += $saldoAkhir;

            $saldoAwalDisplay = $saldoAwal == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($saldoAwal);
            $pembelianDisplay = $pembelian == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($pembelian);
            $penjualanDisplay = $penjualan == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($penjualan);
            $penghapusanDisplay = $penghapusan == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($penghapusan);
            $saldoAkhirDisplay = $saldoAkhir == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($saldoAkhir);

            $html .= <<<HTML
            <tr>
                <td>{$kodeBarcode}</td>
                <td>{$nama}</td>
                <td class="text-right">{$saldoAwalDisplay}</td>
                <td class="text-right">{$pembelianDisplay}</td>
                <td class="text-right">{$penjualanDisplay}</td>
                <td class="text-right">{$penghapusanDisplay}</td>
                <td class="text-right">{$saldoAkhirDisplay}</td>
            </tr>
HTML;
        }

        $totalSaldoAwalDisplay = $totalSaldoAwal == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalSaldoAwal);
        $totalPembelianDisplay = $totalPembelian == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalPembelian);
        $totalPenjualanDisplay = $totalPenjualan == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalPenjualan);
        $totalPenghapusanDisplay = $totalPenghapusan == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalPenghapusan);
        $totalSaldoAkhirDisplay = $totalSaldoAkhir == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalSaldoAkhir);

        $html .= <<<HTML
            <tr class="total-row">
                <td>Total</td>
                <td></td>
                <td class="text-right bold">{$totalSaldoAwalDisplay}</td>
                <td class="text-right bold">{$totalPembelianDisplay}</td>
                <td class="text-right bold">{$totalPenjualanDisplay}</td>
                <td class="text-right bold">{$totalPenghapusanDisplay}</td>
                <td class="text-right bold">{$totalSaldoAkhirDisplay}</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

        return $html;
    }

    private function generateRingkasanKuantitasHtml($startDate, $endDate)
    {
        $periodeBulan = Carbon::parse($startDate)->format('F Y');
        $saldoAwalData = SaldoBarangBulanan::with('barang')
            ->where('periode_bulan', $periodeBulan)
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->get();

        $totalSaldoAwal = 0;
        $totalPembelian = 0;
        $totalPenjualan = 0;
        $totalPenghapusan = 0;
        $totalSaldoAkhir = 0;

        $html = <<<HTML
<div class="report-container">
    <table>
        <thead>
            <tr>
                <th>Kode Barcode</th>
                <th>Nama</th>
                <th>Saldo Awal</th>
                <th>Pembelian</th>
                <th>Penjualan</th>
                <th>Penghapusan</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
HTML;

        foreach ($saldoAwalData as $saldo) {
            $barang = $saldo->barang;
            $kodeBarcode = $barang->kode_barang ?? 'N/A';
            $nama = $barang->nama ?? 'N/A';
            $saldoAwal = $saldo->kuantitas_awal ?? 0;
            $pembelian = Persediaan::where('barang_id', $barang->id)
                ->where('tipe', 'penambahan')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah');
            $penjualan = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->sum('jumlah');
            $penghapusan = Persediaan::where('barang_id', $barang->id)
                ->where('tipe', 'penghapusan')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah');
            $saldoAkhir = $saldoAwal + $pembelian - $penjualan - $penghapusan;

            $totalSaldoAwal += $saldoAwal;
            $totalPembelian += $pembelian;
            $totalPenjualan += $penjualan;
            $totalPenghapusan += $penghapusan;
            $totalSaldoAkhir += $saldoAkhir;

            $saldoAwalDisplay = $saldoAwal == 0 ? '0' : $saldoAwal;
            $pembelianDisplay = $pembelian == 0 ? '0' : $pembelian;
            $penjualanDisplay = $penjualan == 0 ? '0' : $penjualan;
            $penghapusanDisplay = $penghapusan == 0 ? '0' : $penghapusan;
            $saldoAkhirDisplay = $saldoAkhir == 0 ? '0' : $saldoAkhir;

            $html .= <<<HTML
            <tr>
                <td>{$kodeBarcode}</td>
                <td>{$nama}</td>
                <td class="text-right">{$saldoAwalDisplay}</td>
                <td class="text-right">{$pembelianDisplay}</td>
                <td class="text-right">{$penjualanDisplay}</td>
                <td class="text-right">{$penghapusanDisplay}</td>
                <td class="text-right">{$saldoAkhirDisplay}</td>
            </tr>
HTML;
        }

        $totalSaldoAwalDisplay = $totalSaldoAwal == 0 ? '0' : $totalSaldoAwal;
        $totalPembelianDisplay = $totalPembelian == 0 ? '0' : $totalPembelian;
        $totalPenjualanDisplay = $totalPenjualan == 0 ? '0' : $totalPenjualan;
        $totalPenghapusanDisplay = $totalPenghapusan == 0 ? '0' : $totalPenghapusan;
        $totalSaldoAkhirDisplay = $totalSaldoAkhir == 0 ? '0' : $totalSaldoAkhir;

        $html .= <<<HTML
            <tr class="total-row">
                <td>Total</td>
                <td></td>
                <td class="text-right bold">{$totalSaldoAwalDisplay}</td>
                <td class="text-right bold">{$totalPembelianDisplay}</td>
                <td class="text-right bold">{$totalPenjualanDisplay}</td>
                <td class="text-right bold">{$totalPenghapusanDisplay}</td>
                <td class="text-right bold">{$totalSaldoAkhirDisplay}</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

        return $html;
    }

    private function generateMarginLabaHtml($startDate, $endDate)
    {
        $barangs = Barang::where('status_titipan', false)->get();

        $totalPenjualan = 0;
        $totalBiayaPokok = 0;
        $totalLaba = 0;

        $html = <<<HTML
<div class="report-container">
    <table>
        <thead>
            <tr>
                <th>Kode Barcode</th>
                <th>Nama</th>
                <th>Penjualan</th>
                <th>Biaya Pokok Penjualan</th>
                <th>Laba</th>
                <th>Margin</th>
            </tr>
        </thead>
        <tbody>
HTML;

        foreach ($barangs as $barang) {
            $jumlahTerjual = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->sum('jumlah');
            $penjualan = $jumlahTerjual * $barang->harga_jual;
            $biayaPokok = $this->calculateFifoCogs($barang->id, $jumlahTerjual, $startDate, $endDate);
            $laba = $penjualan - $biayaPokok;
            $margin = $penjualan > 0 ? ($laba / $penjualan) * 100 : 0;

            $totalPenjualan += $penjualan;
            $totalBiayaPokok += $biayaPokok;
            $totalLaba += $laba;

            $penjualanDisplay = $penjualan == 0 ? '-' : 'Rp ' . $this->formatRupiah($penjualan);
            $biayaPokokDisplay = $biayaPokok == 0 ? '-' : 'Rp ' . $this->formatRupiah($biayaPokok);
            $labaDisplay = $laba == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($laba);
            $marginDisplay = $margin == 0 ? '0%' : $this->formatPercentage($margin);

            $html .= <<<HTML
            <tr>
                <td>{$barang->kode_barang}</td>
                <td>{$barang->nama}</td>
                <td class="text-right">{$penjualanDisplay}</td>
                <td class="text-right">{$biayaPokokDisplay}</td>
                <td class="text-right">{$labaDisplay}</td>
                <td class="text-right">{$marginDisplay}</td>
            </tr>
HTML;
        }

        $totalPenjualanDisplay = $totalPenjualan == 0 ? '-' : 'Rp ' . $this->formatRupiah($totalPenjualan);
        $totalBiayaPokokDisplay = $totalBiayaPokok == 0 ? '-' : 'Rp ' . $this->formatRupiah($totalBiayaPokok);
        $totalLabaDisplay = $totalLaba == 0 ? 'Rp 0' : 'Rp ' . $this->formatRupiah($totalLaba);
        $totalMargin = $totalPenjualan > 0 ? ($totalLaba / $totalPenjualan) * 100 : 0;
        $totalMarginDisplay = $totalMargin == 0 ? '0%' : $this->formatPercentage($totalMargin);

        $html .= <<<HTML
            <tr class="total-row">
                <td colspan="2">Total</td>
                <td class="text-right bold">{$totalPenjualanDisplay}</td>
                <td class="text-right bold">{$totalBiayaPokokDisplay}</td>
                <td class="text-right bold">{$totalLabaDisplay}</td>
                <td class="text-right bold">{$totalMarginDisplay}</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

        return $html;
    }

    private function generateLabaRugiHtml($startDate, $endDate)
    {
        $bagiHasilByType = [];
        $details = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->with(['transaksi', 'barang.hasilBagi'])
        ->whereHas('barang', function ($query) {
            $query->where('status_titipan', true);
        })
        ->get();

        foreach ($details as $detail) {
            $barang = $detail->barang;
            if ($barang && $barang->status_titipan && $barang->hasilBagi) {
                $tipe = (int)$barang->hasilBagi->tipe;
                $bagiHasilByType[$tipe] = ($bagiHasilByType[$tipe] ?? 0) + ($tipe * $detail->jumlah);
            }
        }

        $pendapatanBagiHasil = array_sum($bagiHasilByType);
        $penjualanBarang = KasirTransaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('details.barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $keuntunganKas = KasKeuntungan::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPendapatan = $pendapatanBagiHasil + $penjualanBarang + $keuntunganKas;

        $jumlahTerjualTotal = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->whereHas('barang', function ($query) {
            $query->where('status_titipan', false);
        })
        ->groupBy('barang_id')
        ->select('barang_id', DB::raw('SUM(jumlah) as total_jumlah'))
        ->get();

        $totalBiayaPokok = 0;
        foreach ($jumlahTerjualTotal as $item) {
            $totalBiayaPokok += $this->calculateFifoCogs($item->barang_id, $item->total_jumlah, $startDate, $endDate);
        }

        $biayaGaji = GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->sum('jumlah');
        $kerugianPersediaan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'penghapusan')
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $kerugianKas = KasKerugian::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');

        // Ambil pengeluaran dengan deskripsi
        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->select('deskripsi', DB::raw('SUM(jumlah) as total'))
            ->groupBy('deskripsi')
            ->get();

        $totalPengeluaran = $pengeluarans->sum('total');

        $totalBiaya = $totalBiayaPokok + $biayaGaji + $kerugianPersediaan + $kerugianKas + $totalPengeluaran;

        $labaRugiBersih = $totalPendapatan - $totalBiaya;

        $html = <<<HTML
<div class="report-container">
    <table>
        <thead>
            <tr><th colspan="2">Laporan Laba Rugi</th></tr>
            <tr><th>Kategori</th><th class="text-right">Jumlah</th></tr>
        </thead>
        <tbody>
            <tr class="section-header"><td colspan="2">Pendapatan</td></tr>
HTML;
        foreach ($bagiHasilByType as $tipe => $jumlah) {
            $html .= <<<HTML
            <tr><td class="subcategory">Pendapatan Bagi Hasil {$tipe}</td><td class="text-right">Rp {$this->formatRupiah($jumlah)}</td></tr>
HTML;
        }
        $html .= <<<HTML
            <tr><td>Penjualan Barang Dagang</td><td class="text-right">Rp {$this->formatRupiah($penjualanBarang)}</td></tr>
            <tr><td>Keuntungan Kas</td><td class="text-right">Rp {$this->formatRupiah($keuntunganKas)}</td></tr>
            <tr class="total-row"><td>Total - Pendapatan</td><td class="text-right bold">Rp {$this->formatRupiah($totalPendapatan)}</td></tr>
            <tr class="section-header"><td colspan="2">Dikurangi: Biaya</td></tr>
            <tr><td>Harga Pokok Penjualan</td><td class="text-right">Rp {$this->formatRupiah($totalBiayaPokok)}</td></tr>
            <tr><td>Kerugian Persediaan</td><td class="text-right">Rp {$this->formatRupiah($kerugianPersediaan)}</td></tr>
            <tr><td>Biaya Gaji Karyawan</td><td class="text-right">Rp {$this->formatRupiah($biayaGaji)}</td></tr>
            <tr><td>Kerugian Kas</td><td class="text-right">Rp {$this->formatRupiah($kerugianKas)}</td></tr>
HTML;
        // Tambahkan detail pengeluaran
        foreach ($pengeluarans as $pengeluaran) {
            $html .= <<<HTML
            <tr><td>{$pengeluaran->deskripsi}</td><td class="text-right">Rp {$this->formatRupiah($pengeluaran->total)}</td></tr>
HTML;
        }
        $html .= <<<HTML
            <tr class="total-row"><td>Total - Biaya</td><td class="text-right bold">Rp {$this->formatRupiah($totalBiaya)}</td></tr>
            <tr class="highlight"><td>Laba (Rugi) Bersih</td><td class="text-right bold">Rp {$this->formatRupiah($labaRugiBersih)}</td></tr>
        </tbody>
    </table>
</div>
HTML;

        return $html;
    }

    private function formatRupiah($value)
    {
        return number_format($value, 2, ',', '.');
    }

    private function formatPercentage($value)
    {
        return number_format($value, 0) . '%';
    }

    private function getSaldoAwalKas($startDate)
    {
        $periodeBulan = Carbon::parse($startDate)->format('F Y');
        $saldoKasBulanan = SaldoKasBulanan::where('periode_bulan', $periodeBulan)->first();
        return $saldoKasBulanan ? $saldoKasBulanan->saldo_awal : 0;
    }

    private function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function getReportTitle($type)
    {
        $titles = [
            'penerimaan_pembayaran' => 'Ringkasan Penerimaan & Pembayaran',
            'buku_besar' => 'Ringkasan Buku Besar',
            'nilai_persediaan' => 'Ringkasan Nilai Persediaan',
            'margin_laba' => 'Margin Laba Persediaan Barang',
            'laba_rugi' => 'Laporan Laba Rugi',
            'ringkasan_kuantitas' => 'Ringkasan Kuantitas Persediaan',
            'laporan_tahunan' => 'Laporan Tahunan',
            'kas_titipan' => 'Ringkasan Saldo Kas Titipan',
        ];
        return $titles[$type] ?? 'Laporan';
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}