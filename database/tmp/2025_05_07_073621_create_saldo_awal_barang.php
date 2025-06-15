<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saldo_barang_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan'); // Format: "January 2025"
            $table->foreignId('barang_id')->constrained()->onDelete('cascade');
            $table->integer('kuantitas_awal'); // Kuantitas awal barang untuk bulan tersebut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_barang_bulanan');
    }
};