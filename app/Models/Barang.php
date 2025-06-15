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
        return $this->detailTransaksis()
            ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get()
            ->sum(function ($detail) {
                return $detail->jumlah * $this->harga_pokok;
            });
    }
}