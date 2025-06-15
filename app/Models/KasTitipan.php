<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasTitipan extends Model
{
    protected $fillable = [
        'barang_id',
        'saldo_kas',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}