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
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

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
        $periodeBulan = Carbon::create($this->year, $this->month, 1)->format('F Y');
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();

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
        $previousMonth = $startDate->copy()->subMonth();
        $previousPeriode = $previousMonth->format('F Y');
        $previousSaldo = SaldoKasBulanan::where('periode_bulan', $previousPeriode)->first();
        $saldoAwal = $previousSaldo ? ($previousSaldo->saldo_akhir ?? $previousSaldo->saldo_awal ?? 0) : 0;
        $saldoAkhir = $saldoAwal + $tambahanBersih;

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
            ['saldo_awal' => $saldoAkhir]
        );
    }
}