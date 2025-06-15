<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KasirTransaksi extends Model
{
    use LogsActivity;

    protected $table = 'kasir_transaksis';

    protected $fillable = [
        'unix_id',
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'tanggal',
        'shift_id',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'tanggal' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->unix_id)) {
                $lastUnixId = static::max('unix_id');
                $lastNumber = $lastUnixId ? (int)substr($lastUnixId, 0, 4) : 0;
                $nextNumber = $lastNumber + 1;
                $datePart = Carbon::now()->format('ymd');
                $model->unix_id = sprintf('%04d', $nextNumber) . $datePart;
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('transaksi')
            ->setDescriptionForEvent(fn(string $eventName) => "Transaksi telah {$eventName}");
    }
}