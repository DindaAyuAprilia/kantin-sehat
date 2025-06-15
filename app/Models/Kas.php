<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $fillable = ['saldo_kas'];

    // Metode untuk menghitung saldo awal
    public static function saldoAwal($date)
    {
        return self::where('created_at', '<', $date)->sum('saldo_kas');
    }
}