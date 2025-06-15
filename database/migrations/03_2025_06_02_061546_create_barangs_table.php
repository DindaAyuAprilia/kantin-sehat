<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama');
            $table->decimal('harga_pokok', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(true); 
            $table->boolean('status_titipan')->default(false);
            $table->enum('tipe_barang', ['snack', 'minuman', 'kebutuhan', 'titipan', 'lainnya'])->default('lainnya');
            $table->foreignId('hasil_bagi_id')->nullable()->constrained('hasil_bagis')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};