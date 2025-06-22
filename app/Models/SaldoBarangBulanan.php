<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SaldoBarangBulanan extends Model
{
    use LogsActivity;

    protected $table = 'saldo_barang_bulanans';

    protected $fillable = [
        'periode_bulan',
        'barang_id',
        'kuantitas_awal',
        'kuantitas_akhir',
        'nilai_kuantitas_awal',
        'nilai_kuantitas_akhir',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('saldo_barang_bulanan')
            ->setDescriptionForEvent(fn(string $eventName) => "Saldo barang bulanan telah {$eventName}");
    }
}