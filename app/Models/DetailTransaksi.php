<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DetailTransaksi extends Model
{
    use LogsActivity;

    protected $table = 'detail_transaksis'; // Pastikan nama tabel sesuai

    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'subtotal', 'harga_satuan'];

    public function transaksi()
    {
        return $this->belongsTo(KasirTransaksi::class, 'transaksi_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('detail_transaksi')
            ->setDescriptionForEvent(fn(string $eventName) => "Detail transaksi telah {$eventName}");
    }
}