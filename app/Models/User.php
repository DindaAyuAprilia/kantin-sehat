<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'nama', 'email', 'password', 'role', 'status', 'tanggal_berhenti',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tanggal_berhenti' => 'datetime',
    ];

    public function kasirTransaksis()
    {
        return $this->hasMany(KasirTransaksi::class);
    }

    public function persediaans()
    {
        return $this->hasMany(Persediaan::class, 'kelola_id');
    }

    public function gajiPembayarans()
    {
        return $this->hasMany(GajiPembayaran::class, 'karyawan_id');
    }

    public function isPaidForMonth($month)
    {
        return $this->gajiPembayarans()->where('periode_bulan', $month)->exists();
    }
}