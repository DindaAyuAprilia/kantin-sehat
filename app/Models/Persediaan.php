<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Spatie\Activitylog\Traits\LogsActivity;
   use Spatie\Activitylog\LogOptions;

   class Persediaan extends Model
   {
       use LogsActivity;

       protected $fillable = ['barang_id', 'kelola_id', 'tipe', 'tanggal', 'jumlah', 'alasan', 'total_harga', 'sisa_stok'];

       public function barang()
       {
           return $this->belongsTo(Barang::class);
       }

       public function kelola()
       {
           return $this->belongsTo(User::class, 'kelola_id');
       }

       public function getActivitylogOptions(): LogOptions
       {
           return LogOptions::defaults()
               ->logFillable()
               ->logOnlyDirty()
               ->useLogName('persediaan')
               ->setDescriptionForEvent(fn(string $eventName) => "Persediaan telah {$eventName}");
       }
   }