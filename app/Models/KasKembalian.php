<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasKembalian extends Model
{
    protected $table = 'kas_kembalian';

    protected $fillable = [
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}