<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama',
        'harga_pokok',
        'harga_jual',
        'stok',
        'is_active',
        'status_titipan',
        'tipe_barang',
        'hasil_bagi_id',
    ];

    protected $casts = [
        'harga_pokok' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'is_active' => 'boolean',
        'status_titipan' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function persediaans()
    {
        return $this->hasMany(Persediaan::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function hasilBagi()
    {
        return $this->belongsTo(HasilBagi::class);
    }

    public function kasTitipan(): HasMany
    {
        return $this->hasMany(KasTitipan::class, 'barang_id');
    }

    public function penjualanPeriode($startDate, $endDate)
    {
        return $this->detailTransaksis()
            ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->sum('subtotal');
    }

    public function biayaPokokPenjualan($startDate, $endDate)
    {
        $details = $this->detailTransaksis()
            ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get();

        $totalQuantitySold = $details->sum('jumlah');
        return $this->calculateFifoCogs($totalQuantitySold, $startDate, $endDate);
    }

    public function calculateFifoCogs($quantityNeeded, $startDate, $endDate): float
    {
        $persediaans = $this->persediaans()
            ->whereIn('tipe', ['pembelian', 'penambahan_titipan'])
            ->where('tanggal', '<=', $endDate)
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalBiayaPokok = 0;
        $quantityAllocated = 0;

        foreach ($persediaans as $persediaan) {
            if ($quantityAllocated >= $quantityNeeded) {
                break;
            }

            // $available = $persediaan->jumlah; // Gunakan jumlah asli, bukan sisa_stok
            // $used = min($available, $quantityNeeded - $quantityAllocated);
            // $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
            // $totalBiayaPokok += $used * $biayaPokokPerUnit;
            // $quantityAllocated += $used;

            $available = $persediaan->jumlah; 
            $used = min($available, $quantityNeeded - $quantityAllocated);
            
            if($persediaan->jumlah !=0){
                $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
            }
            else {
                $biayaPokokPerUnit = 0;
            }
            
            $totalBiayaPokok += $used * $biayaPokokPerUnit;
            $quantityAllocated += $used;
        }

        return $totalBiayaPokok;
    }
}