<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saldo_kas_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan'); // Format: "May 2025"
            $table->decimal('saldo_awal', 15, 2)->default(0.00);
            $table->decimal('saldo_akhir', 15, 2)->default(0.00); // Kolom baru untuk menyimpan saldo akhir
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldo_kas_bulanans');
    }
};