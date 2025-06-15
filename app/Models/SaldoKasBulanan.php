<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoKasBulanan extends Model
{
    protected $table = 'saldo_kas_bulanans';
    protected $fillable = ['periode_bulan', 'saldo_awal', 'saldo_akhir'];
}