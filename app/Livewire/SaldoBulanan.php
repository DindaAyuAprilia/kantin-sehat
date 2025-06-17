<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SaldoKasBulanan;
use App\Models\SaldoBarangBulanan;
use App\Models\Pengeluaran;
use App\Models\KasKeuntungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class SaldoBulanan extends Component
{
    public $selectedMonth;
    public $saldoKasBulanan;
    public $saldoBarangBulanan;
    public $activeTab = 'kas';
    public $searchBarang = '';

    public function mount(): void
    {
        Log::info('SaldoBulanan: Memulai komponen', ['selectedMonth' => $this->selectedMonth]);
        $this->selectedMonth = $this->selectedMonth ?? now()->format('Y-m');
        $this->loadSaldoBulanan();
    }

    public function loadSaldoBulanan(): void
    {
        try {
            $periodeBulan = Carbon::parse($this->selectedMonth)->format('F Y');
            Log::info('SaldoBulanan: Memuat data saldo bulanan', ['periodeBulan' => $periodeBulan]);

            $this->saldoKasBulanan = SaldoKasBulanan::where('periode_bulan', $periodeBulan)->first();
            $this->saldoBarangBulanan = SaldoBarangBulanan::with('barang')
                ->where('periode_bulan', $periodeBulan)
                ->when($this->searchBarang, function ($query) {
                    $query->whereHas('barang', function ($q) {
                        $q->where('nama', 'like', '%' . $this->searchBarang . '%');
                    });
                })
                ->get();

            Log::info('SaldoBulanan: Data berhasil dimuat', [
                'saldoKasBulanan' => $this->saldoKasBulanan ? $this->saldoKasBulanan->toArray() : null,
                'saldoBarangBulananCount' => $this->saldoBarangBulanan->count()
            ]);
        } catch (\Exception $e) {
            Log::error('SaldoBulanan: Gagal memuat data saldo bulanan', ['error' => $e->getMessage()]);
            $this->saldoKasBulanan = null;
            $this->saldoBarangBulanan = new Collection();
            session()->flash('error', 'Gagal memuat data saldo bulanan: ' . $e->getMessage());
            $this->dispatch('swal:error', message: 'Gagal memuat data saldo bulanan: ' . $e->getMessage());
        }
    }

    public function setActiveTab($tab): void
    {
        try {
            Log::info('SaldoBulanan: Mengubah tab aktif', ['tab' => $tab]);
            $this->activeTab = $tab;
            $this->loadSaldoBulanan();
        } catch (\Exception $e) {
            Log::error('SaldoBulanan: Gagal mengubah tab aktif', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal mengubah tab: ' . $e->getMessage());
            $this->dispatch('swal:error', message: 'Gagal mengubah tab: ' . $e->getMessage());
        }
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'selectedMonth') {
            try {
                Log::info('SaldoBulanan: selectedMonth diperbarui', ['selectedMonth' => $this->selectedMonth]);
                $this->validate([
                    'selectedMonth' => 'required|date_format:Y-m',
                ], [
                    'selectedMonth.required' => 'Bulan harus dipilih.',
                    'selectedMonth.date_format' => 'Format bulan tidak valid.',
                ]);
                $this->loadSaldoBulanan();
            } catch (\Exception $e) {
                Log::error('SaldoBulanan: Gagal memvalidasi selectedMonth', ['error' => $e->getMessage()]);
                $this->dispatch('swal:error', message: 'Gagal memvalidasi bulan: ' . $e->getMessage());
            }
        } elseif ($propertyName === 'searchBarang') {
            Log::info('SaldoBulanan: searchBarang diperbarui', ['searchBarang' => $this->searchBarang]);
            $this->loadSaldoBulanan();
        }
    }

    public function recalculateMonthlySaldo(): void
    {
        try {
            $month = Carbon::parse($this->selectedMonth)->month;
            $year = Carbon::parse($this->selectedMonth)->year;
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            $bagiHasilByType = [];
            $details = \App\Models\DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
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
            $penjualanBarang = \App\Models\KasirTransaksi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereHas('details.barang', function ($query) {
                    $query->where('status_titipan', false);
                })
                ->sum('total_harga');
            $keuntunganKas = KasKeuntungan::whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah');
            $totalPenerimaan = $pendapatanBagiHasil + $penjualanBarang + $keuntunganKas;

            $biayaGaji = \App\Models\GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
                ->sum('jumlah');
            $kerugianPenjualan = \App\Models\Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                ->where('tipe', 'penghapusan')
                ->whereHas('barang', function ($query) {
                    $query->where('status_titipan', false);
                })
                ->sum('total_harga');
            $persediaanDiTangan = \App\Models\Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                ->where('tipe', 'pembelian')
                ->whereHas('barang', function ($query) {
                    $query->where('status_titipan', false);
                })
                ->sum('total_harga');
            $kerugianKas = \App\Models\KasKerugian::whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah');
            $pengeluaran = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah');
            $totalPembayaran = $biayaGaji + $kerugianPenjualan + $persediaanDiTangan + $kerugianKas + $pengeluaran;

            $tambahanBersih = $totalPenerimaan - $totalPembayaran;
            $previousMonth = $startDate->copy()->subMonth();
            $previousPeriode = $previousMonth->format('F Y');
            $previousSaldo = SaldoKasBulanan::where('periode_bulan', $previousPeriode)->first();
            $saldoAwal = $previousSaldo ? ($previousSaldo->saldo_akhir ?? $previousSaldo->saldo_awal ?? 0) : 0;
            $saldoAkhir = $saldoAwal + $tambahanBersih;

            $periodeBulan = Carbon::parse($this->selectedMonth)->format('F Y');
            SaldoKasBulanan::updateOrCreate(
                ['periode_bulan' => $periodeBulan],
                [
                    'saldo_awal' => $saldoAwal,
                    'saldo_akhir' => $saldoAkhir,
                ]
            );

            $nextMonth = $startDate->copy()->addMonth();
            $nextPeriode = $nextMonth->format('F Y');
            SaldoKasBulanan::updateOrCreate(
                ['periode_bulan' => $nextPeriode],
                [
                    'saldo_awal' => $saldoAkhir,
                ]
            );

            $this->loadSaldoBulanan();
            session()->flash('success', 'Saldo akhir bulan berhasil dihitung ulang dan diperbarui.');
            $this->dispatch('swal:success', message: 'Saldo berhasil dihitung ulang!');
        } catch (\Exception $e) {
            Log::error('SaldoBulanan: Gagal menghitung ulang saldo', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal menghitung ulang saldo: ' . $e->getMessage());
            $this->dispatch('swal:error', message: 'Gagal menghitung ulang saldo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        Log::info('SaldoBulanan: Merender tampilan', [
            'saldoKasBulanan' => $this->saldoKasBulanan ? $this->saldoKasBulanan->toArray() : null,
            'saldoBarangBulananCount' => $this->saldoBarangBulanan->count(),
            'activeTab' => $this->activeTab
        ]);

        return view('livewire.saldo-bulanan')->with([
            'saldoKasBulanan' => $this->saldoKasBulanan,
            'saldoBarangBulanan' => $this->saldoBarangBulanan,
            'activeTab' => $this->activeTab,
            'selectedMonth' => $this->selectedMonth,
        ]);
    }
}