<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasKeuntungan extends Model
{
    protected $fillable = ['user_id', 'jumlah', 'tanggal', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}