<?php

namespace App\Jobs;

use App\Models\DetailTransaksi;
use App\Models\GajiPembayaran;
use App\Models\KasKeuntungan;
use App\Models\KasKerugian;
use App\Models\KasirTransaksi;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use App\Models\SaldoKasBulanan;
use App\Models\SaldoBarangBulanan;
use App\Models\Barang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateMonthlySaldo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $month;
    protected $year;

    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function handle(): void
    {
    try {
        $periodeBulan = Carbon::create($this->year, $this->month, 1)->format('F Y');
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();
        $previousMonth = $startDate->copy()->subMonth();
        $previousPeriode = $previousMonth->format('F Y');
        $nextMonth = $startDate->copy()->addMonth();
        $nextPeriode = $nextMonth->format('F Y');

        Log::info('UpdateMonthlySaldo: Memulai perhitungan saldo bulanan', [
            'periode_bulan' => $periodeBulan,
            'month' => $this->month,
            'year' => $this->year,
        ]);

        // Perhitungan Saldo Kas
        $bagiHasilByType = [];
        $details = DetailTransaksi::whereHas('transaksi', fn($query) => 
            $query->whereBetween('tanggal', [$startDate, $endDate])
        )
            ->with(['transaksi', 'barang.hasilBagi'])
            ->whereHas('barang', fn($query) => $query->where('status_titipan', true))
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
            ->whereHas('details.barang', fn($query) => $query->where('status_titipan', false))
            ->sum('total_harga');
        $keuntunganKas = KasKeuntungan::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPenerimaan = $pendapatanBagiHasil + $penjualanBarang + $keuntunganKas;

        $biayaGaji = GajiPembayaran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->sum('jumlah');
        $kerugianPenjualan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'penghapusan')
            ->whereHas('barang', fn($query) => $query->where('status_titipan', false))
            ->sum('total_harga');
        $persediaanDiTangan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'pembelian')
            ->whereHas('barang', fn($query) => $query->where('status_titipan', false))
            ->sum('total_harga');
        $kerugianKas = KasKerugian::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
        $totalPembayaran = $biayaGaji + $kerugianPenjualan + $persediaanDiTangan + $kerugianKas + $pengeluaran;

        $tambahanBersih = $totalPenerimaan - $totalPembayaran;
        $previousSaldo = SaldoKasBulanan::where('periode_bulan', $previousPeriode)->first();
        $saldoAwal = $previousSaldo ? ($previousSaldo->saldo_akhir ?? $previousSaldo->saldo_awal ?? 0) : 0;
        $saldoAkhir = $saldoAwal + $tambahanBersih;

        // Simpan Saldo Kas
        SaldoKasBulanan::updateOrCreate(
            ['periode_bulan' => $periodeBulan],
            [
                'saldo_awal' => $saldoAwal,
                'saldo_akhir' => $saldoAkhir,
            ]
        );

        SaldoKasBulanan::updateOrCreate(
            ['periode_bulan' => $nextPeriode],
            ['saldo_awal' => $saldoAkhir]
        );

        // Perhitungan Saldo Barang (hanya untuk barang dengan status_titipan = false)
        $barangList = Barang::where('status_titipan', false)->get();
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
            $penjualan = DetailTransaksi::whereHas('transaksi', fn($query) => 
                $query->whereBetween('tanggal', [$startDate, $endDate])
            )
                ->where('barang_id', $barang->id)
                ->sum('jumlah') ?? 0;

            $nilaiPenjualan = 0;
            if ($penjualan > 0) {
                $persediaans = Persediaan::where('barang_id', $barang->id)
                    ->whereIn('tipe', ['pembelian'])
                    ->where('tanggal', '<=', $endDate)
                    ->where('sisa_stok', '>', 0)
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                $quantityNeeded = $penjualan;
                foreach ($persediaans as $persediaan) {
                    if ($quantityNeeded <= 0) break;
                    $available = min($persediaan->sisa_stok, $quantityNeeded);
                    $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
                    $nilaiPenjualan += $available * $biayaPokokPerUnit;
                    $quantityNeeded -= $available;
                }
            }

            // Hitung penghapusan
            $penghapusan = Persediaan::whereBetween('tanggal', [$startDate, $endDate])
                ->where('barang_id', $barang->id)
                ->where('tipe', 'penghapusan')
                ->sum('jumlah') ?? 0;

            $nilaiPenghapusan = 0;
            if ($penghapusan > 0) {
                $persediaans = Persediaan::where('barang_id', $barang->id)
                    ->whereIn('tipe', ['pembelian'])
                    ->where('tanggal', '<=', $endDate)
                    ->where('sisa_stok', '>', 0)
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                $quantityNeeded = $penghapusan;
                foreach ($persediaans as $persediaan) {
                    if ($quantityNeeded <= 0) break;
                    $available = min($persediaan->sisa_stok, $quantityNeeded);
                    $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
                    $nilaiPenghapusan += $available * $biayaPokokPerUnit;
                    $quantityNeeded -= $available;
                }
            }

            // Hitung kuantitas dan nilai akhir
            $kuantitasAkhir = max(0, $kuantitasAwal + $pembelian - $penjualan - $penghapusan);
            $nilaiKuantitasAkhir = max(0, $nilaiKuantitasAwal + $nilaiPembelian - $nilaiPenjualan - $nilaiPenghapusan);

            // Logging untuk debugging
            Log::info('UpdateMonthlySaldo: Perhitungan saldo barang', [
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
                Log::info('UpdateMonthlySaldo: Barang tidak memiliki transaksi, menggunakan nilai default', [
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

        Log::info('UpdateMonthlySaldo: Selesai perhitungan saldo bulanan', [
            'periode_bulan' => $periodeBulan,
        ]);
    } catch (\Exception $e) {
        Log::error('UpdateMonthlySaldo: Gagal menghitung ulang saldo', [
            'periode_bulan' => $periodeBulan,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        throw $e; // Re-throw untuk memungkinkan retry atau penanganan lebih lanjut
    }
    }
}