<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SaldoKasBulanan;
use App\Models\SaldoBarangBulanan;
use App\Models\Pengeluaran;
use App\Models\KasKeuntungan;
use App\Models\Persediaan;
use App\Models\KasirTransaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminSaldoBulanan extends Component
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
            $periodeBulan = Carbon::parse($this->selectedMonth)->format('F Y');

            // Perhitungan Saldo Kas
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

            $biayaGaji = \App\Models\GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
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

            // Perhitungan Saldo Barang (hanya untuk barang dengan status_titipan = false)
            $barangList = \App\Models\Barang::where('status_titipan', false)->get();
            foreach ($barangList as $barang) {
                // Ambil saldo bulan sebelumnya
                $previousSaldoBarang = SaldoBarangBulanan::where('periode_bulan', $previousPeriode)
                    ->where('barang_id', $barang->id)
                    ->first();

                $kuantitasAwal = $previousSaldoBarang ? ($previousSaldoBarang->kuantitas_akhir ?? 0) : 0;
                $nilaiKuantitasAwal = $previousSaldoBarang ? ($previousSaldoBarang->nilai_kuantitas_akhir ?? 0) : 0;

                // Hitung transaksi pembelian
                $pembelian = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                    ->where('barang_id', $barang->id)
                    ->where('tipe', 'pembelian')
                    ->sum('jumlah') ?? 0;

                $nilaiPembelian = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                    ->where('barang_id', $barang->id)
                    ->where('tipe', 'pembelian')
                    ->sum('total_harga') ?? 0;

                // Hitung transaksi penjualan
                $penjualan = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->where('barang_id', $barang->id)
                ->sum('jumlah') ?? 0;

                $nilaiPenjualan = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->where('barang_id', $barang->id)
                ->sum('subtotal') ?? 0;

                // Hitung penghapusan
                $penghapusan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                    ->where('barang_id', $barang->id)
                    ->where('tipe', 'penghapusan')
                    ->sum('jumlah') ?? 0;

                $nilaiPenghapusan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                    ->where('barang_id', $barang->id)
                    ->where('tipe', 'penghapusan')
                    ->sum('total_harga') ?? 0;

                // Hitung kuantitas dan nilai akhir
                $kuantitasAkhir = max(0, $kuantitasAwal + $pembelian - $penjualan - $penghapusan);
                $nilaiKuantitasAkhir = max(0, $nilaiKuantitasAwal + $nilaiPembelian - $nilaiPenjualan - $nilaiPenghapusan);

                // Logging untuk debugging
                Log::info('SaldoBulanan: Perhitungan saldo barang', [
                    'barang_id' => $barang->id,
                    'periode_bulan' => $periodeBulan,
                    'kuantitas_awal' => $kuantitasAwal,
                    'kuantitas_akhir' => $kuantitasAkhir,
                    'nilai_kuantitas_awal' => $nilaiKuantitasAwal,
                    'nilai_kuantitas_akhir' => $nilaiKuantitasAkhir,
                    'pembelian' => $pembelian,
                    'nilai_pembelian' => $nilaiPembelian,
                    'penjualan' => $penjualan,
                    'nilai_penjualan' => $nilaiPenjualan,
                    'penghapusan' => $penghapusan,
                    'nilai_penghapusan' => $nilaiPenghapusan,
                    'status_titipan' => $barang->status_titipan,
                ]);

                // Validasi sebelum menyimpan
                $kuantitasAkhir = is_null($kuantitasAkhir) ? 0 : (int)$kuantitasAkhir;
                $nilaiKuantitasAkhir = is_null($nilaiKuantitasAkhir) ? 0.0 : (float)$nilaiKuantitasAkhir;

                if ($kuantitasAkhir === 0 && $nilaiKuantitasAkhir === 0.0 && $pembelian === 0 && $penjualan === 0 && $penghapusan === 0) {
                    Log::info('SaldoBulanan: Barang tidak memiliki transaksi, menggunakan nilai default', [
                        'barang_id' => $barang->id,
                        'periode_bulan' => $periodeBulan,
                    ]);
                }

                // Simpan Saldo Barang
                SaldoBarangBulanan::updateOrCreate(
                    [
                        'periode_bulan' => $periodeBulan,
                        'barang_id' => $barang->id,
                    ],
                    [
                        'kuantitas_awal' => (int)$kuantitasAwal,
                        'kuantitas_akhir' => (int)$kuantitasAkhir,
                        'nilai_kuantitas_awal' => (float)$nilaiKuantitasAwal,
                        'nilai_kuantitas_akhir' => (float)$nilaiKuantitasAkhir,
                    ]
                );

                // Update saldo awal untuk bulan berikutnya
                SaldoBarangBulanan::updateOrCreate(
                    [
                        'periode_bulan' => $nextPeriode,
                        'barang_id' => $barang->id,
                    ],
                    [
                        'kuantitas_awal' => (int)$kuantitasAkhir,
                        'nilai_kuantitas_awal' => (float)$nilaiKuantitasAkhir,
                    ]
                );
            }

            $this->loadSaldoBulanan();
            session()->flash('success', 'Saldo kas dan barang bulan berhasil dihitung ulang dan diperbarui.');
            $this->dispatch('swal:success', message: 'Saldo kas dan barang berhasil dihitung ulang!');
        } catch (\Exception $e) {
            Log::error('SaldoBulanan: Gagal menghitung ulang saldo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

        return view('livewire.admin-saldo-bulanan')->with([
            'saldoKasBulanan' => $this->saldoKasBulanan,
            'saldoBarangBulanan' => $this->saldoBarangBulanan,
            'activeTab' => $this->activeTab,
            'selectedMonth' => $this->selectedMonth,
        ]);
    }
}