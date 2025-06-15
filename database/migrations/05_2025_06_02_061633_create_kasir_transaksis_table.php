<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasir_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('unix_id', 10)->unique(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', 15, 2);
            $table->string('metode_pembayaran');
            $table->date('tanggal');
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasir_transaksis');
    }
};