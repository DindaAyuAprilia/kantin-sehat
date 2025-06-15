<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\KasirTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Persediaan;
use App\Models\KasKerugian;
use App\Models\KasKeuntungan;
use App\Models\SaldoKasBulanan;
use App\Models\GajiPembayaran;
use App\Models\Pengeluaran;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminStockOpname extends Component
{
    use WithPagination;

    public $search = '';
    public $month;
    public $year;
    public $uang_fisik = 0;
    public $physicalStocks = [];
    public $selectedDate;
    public $selectedCashDate; // Tambah properti untuk tanggal kas
    public $isLoading = false;
    public $months = [];
    public $years = [];

    protected $listeners = [
        'confirmAdjustStockWithTransaction' => 'adjustStockWithTransaction',
        'confirmAdjustStockWithoutTransaction' => 'adjustStockWithoutTransaction',
        'confirmAdjustCash' => 'adjustCash',
    ];

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->selectedCashDate = Carbon::now()->format('Y-m-d'); // Inisialisasi tanggal kas

        // Menyiapkan daftar bulan
        $this->months = collect(range(1, 12))->map(function ($m) {
            return [
                'value' => $m,
                'label' => Carbon::create()->month($m)->translatedFormat('F'),
            ];
        })->toArray();

        // Menyiapkan daftar tahun
        $currentYear = Carbon::now()->year;
        $this->years = collect(range($currentYear - 5, $currentYear + 5))->map(function ($y) {
            return [
                'value' => $y,
                'label' => $y,
            ];
        })->toArray();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedUangFisik($value)
    {
        $this->uang_fisik = is_numeric($value) ? max(0, (float) $value) : 0;
    }

    public function updatedPhysicalStocks($value, $barangId)
    {
        $this->physicalStocks[$barangId] = is_numeric($value) && $value !== '' ? max(0, (int) $value) : null;
    }

    public function calculateSystemCash()
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();
        $previousMonth = $startDate->copy()->subMonth();
        $previousPeriode = $previousMonth->format('F Y');

        // Saldo awal bulan sebelumnya
        $previousSaldo = SaldoKasBulanan::where('periode_bulan', $previousPeriode)->first();
        $saldoAwal = $previousSaldo ? ($previousSaldo->saldo_akhir ?? $previousSaldo->saldo_awal ?? 0) : 0;

        // Hitung pendapatan
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
                $tipe = (int)$barang->hasilBagi->tipe; // Gunakan tipe sesuai UpdateMonthlySaldo
                $bagiHasilByType[$tipe] = ($bagiHasilByType[$tipe] ?? 0) + ($tipe * $detail->jumlah);
            }
        }

        $pendapatanBagiHasil = array_sum($bagiHasilByType);
        $penjualanBarang = KasirTransaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('details.barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        // Tambahkan Kas Keuntungan
        $keuntunganKas = KasKeuntungan::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPenerimaan = $pendapatanBagiHasil + $penjualanBarang + $keuntunganKas;

        // Hitung pengeluaran
        $biayaGaji = GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->sum('jumlah');
        $kerugianPenjualan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'penghapusan')
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $persediaanDiTangan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'pembelian')
            ->whereHas('barang', function ($query) {
                $query->where('status_titipan', false);
            })
            ->sum('total_harga');
        $kerugianKas = KasKerugian::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPembayaran = $biayaGaji + $kerugianPenjualan + $persediaanDiTangan + $kerugianKas + $pengeluaran;

        $tambahanBersih = $totalPenerimaan - $totalPembayaran;
        return $saldoAwal + $tambahanBersih;
    }

    public function adjustStockWithTransaction($id, $stock)
    {
        $this->isLoading = true;
        $barangId = $id;
        $physicalStock = $stock;

        $barang = Barang::find($barangId);
        if (!$barang || !isset($this->selectedDate)) {
            $this->dispatch('swal:error', message: 'Data barang atau tanggal tidak valid.');
            $this->isLoading = false;
            return;
        }

        $selisih = $barang->stok - $physicalStock;
        if ($selisih <= 0) {
            $this->dispatch('swal:error', message: 'Stok fisik harus kurang dari stok sistem untuk membuat transaksi.');
            $this->isLoading = false;
            return;
        }

        $transaksi = KasirTransaksi::create([
            'user_id' => Auth::id(),
            'total_harga' => $selisih * $barang->harga_jual,
            'metode_pembayaran' => 'tunai',
            'tanggal' => $this->selectedDate,
            'shift_id' => null,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang->id,
            'jumlah' => $selisih,
            'subtotal' => $selisih * $barang->harga_jual,
            'harga_satuan' => $barang->harga_jual,
        ]);

        $barang->update(['stok' => $physicalStock]);

        $this->physicalStocks[$barangId] = null;
        $this->dispatch('swal:success', message: 'Stok berhasil disesuaikan dengan transaksi.');
        $this->isLoading = false;
    }

    public function adjustStockWithoutTransaction($id, $stock)
    {
        $this->isLoading = true;
        $barangId = $id;
        $physicalStock = $stock;

        $barang = Barang::find($barangId);
        if (!$barang) {
            $this->dispatch('swal:error', message: 'Barang tidak ditemukan.');
            $this->isLoading = false;
            return;
        }

        $selisih = $barang->stok - $physicalStock;
        $tipe = $physicalStock > $barang->stok ? 'penambahan' : 'penghapusan';
        $keterangan = $physicalStock > $barang->stok ? 'Penambahan selisih stok opname' : 'Penghapusan selisih stok opname';

        Persediaan::create([
            'barang_id' => $barang->id,
            'kelola_id' => Auth::id(),
            'tipe' => $tipe,
            'tanggal' => Carbon::now(),
            'jumlah' => abs($selisih),
            'alasan' => $keterangan,
            'total_harga' => abs($selisih) * $barang->harga_pokok,
            'sisa_stok' => $physicalStock,
        ]);

        $barang->update(['stok' => $physicalStock]);

        $this->physicalStocks[$barangId] = null;
        $this->dispatch('swal:success', message: 'Stok berhasil disesuaikan.');
        $this->isLoading = false;
    }

    public function adjustCash()
    {
        $this->isLoading = true;
        if (!isset($this->selectedCashDate)) {
            $this->dispatch('swal:error', message: 'Tanggal penyesuaian kas tidak valid.');
            $this->isLoading = false;
            return;
        }

        $systemCash = $this->calculateSystemCash();
        $selisih = $systemCash - $this->uang_fisik;

        if ($selisih > 0) {
            KasKerugian::create([
                'user_id' => Auth::id(),
                'jumlah' => $selisih,
                'tanggal' => $this->selectedCashDate, // Gunakan tanggal yang dipilih
                'keterangan' => 'Kerugian selisih stok opname',
            ]);
        } elseif ($selisih < 0) {
            KasKeuntungan::create([
                'user_id' => Auth::id(),
                'jumlah' => abs($selisih),
                'tanggal' => $this->selectedCashDate, // Gunakan tanggal yang dipilih
                'keterangan' => 'Pendapatan selisih stok opname',
            ]);
        }

        $periodeBulan = Carbon::create($this->year, $this->month, 1)->format('F Y');
        SaldoKasBulanan::updateOrCreate(
            ['periode_bulan' => $periodeBulan],
            [
                'saldo_awal' => $this->calculateSystemCash(),
                'saldo_akhir' => $this->uang_fisik,
            ]
        );

        $this->dispatch('swal:success', message: 'Kas berhasil disesuaikan.');
        $this->isLoading = false;
    }

    public function render()
    {
        $systemCash = $this->calculateSystemCash();
        $selisihCash = $systemCash - $this->uang_fisik;

        $barangs = Barang::when($this->search, function ($query) {
            $query->where('kode_barang', 'like', '%' . $this->search . '%')
                ->orWhere('nama', 'like', '%' . $this->search . '%');
        })->paginate(25);

        return view('livewire.admin-stock-opname', [
            'barangs' => $barangs,
            'systemCash' => $systemCash,
            'selisihCash' => $selisihCash,
            'months' => $this->months,
            'years' => $this->years,
        ]);
    }
}