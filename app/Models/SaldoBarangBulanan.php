<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoBarangBulanan extends Model
{
    protected $table = 'saldo_barang_bulanans';
    protected $fillable = ['periode_bulan', 'barang_id', 'kuantitas_awal', 'kuantitas_akhir', 'nilai_kuantitas_awal', 'nilai_kuantitas_akhir'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}