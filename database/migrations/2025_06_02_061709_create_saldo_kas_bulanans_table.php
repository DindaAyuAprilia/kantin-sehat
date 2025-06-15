<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldo_kas_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan');
            $table->decimal('saldo_awal', 15, 2);
            $table->decimal('saldo_akhir', 15, 2)->nullable(); // Diubah menjadi nullable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_kas_bulanans');
    }
};