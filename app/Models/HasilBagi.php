<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilBagi extends Model
{
    protected $fillable = ['tipe'];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}