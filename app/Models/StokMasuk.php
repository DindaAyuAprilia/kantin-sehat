<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';

    protected $fillable = [
        'barang_id',
        'jumlah_masuk',
        'harga_beli',
        'sisa_stok',
        'tanggal_masuk',
    ];

    protected $casts = [
        'jumlah_masuk' => 'integer',
        'harga_beli' => 'decimal:2',
        'sisa_stok' => 'integer',
        'tanggal_masuk' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}