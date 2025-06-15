<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'gaji_pembayarans';

    protected $fillable = [
        'karyawan_id',
        'admin_id',
        'tanggal_pembayaran',
        'jumlah',
        'periode_bulan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}