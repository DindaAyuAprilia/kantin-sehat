<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('saldo_barang_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan'); // Kolom untuk menyimpan periode bulan (contoh: "May 2025")
            $table->unsignedBigInteger('barang_id'); // Foreign key ke tabel barangs
            $table->integer('kuantitas_awal')->default(0); // Kuantitas awal barang
            $table->integer('kuantitas_akhir')->default(0); // Kuantitas akhir barang
            $table->decimal('nilai_kuantitas_awal', 15, 2)->default(0.00);
            $table->decimal('nilai_kuantitas_akhir', 15, 2)->default(0.00);
            $table->timestamps();

            // Menambahkan foreign key constraint ke tabel barangs
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldo_barang_bulanans');
    }
};
