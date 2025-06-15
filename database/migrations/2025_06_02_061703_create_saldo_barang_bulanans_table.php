<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldo_barang_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('kuantitas_awal');
            $table->integer('kuantitas_akhir');
            $table->decimal('nilai_kuantitas_awal', 15, 2);
            $table->decimal('nilai_kuantitas_akhir', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_barang_bulanans');
    }
};