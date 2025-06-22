<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saldo_barang_bulanans', function (Blueprint $table) {
            // Ubah kolom kuantitas_akhir untuk memiliki default value 0
            $table->integer('kuantitas_akhir')->default(0)->change();
            
            // Ubah kolom nilai_kuantitas_akhir untuk memiliki default value 0.00
            $table->decimal('nilai_kuantitas_akhir', 15, 2)->default(0.00)->change();
        });
    }

    public function down(): void
    {
        Schema::table('saldo_barang_bulanans', function (Blueprint $table) {
            // Kembalikan kolom ke kondisi tanpa default value
            $table->integer('kuantitas_akhir')->default(null)->change();
            $table->decimal('nilai_kuantitas_akhir', 15, 2)->default(null)->change();
        });
    }
};