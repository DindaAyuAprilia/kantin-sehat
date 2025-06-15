<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('transaksis', 'kasir_transaksi');
    }

    public function down(): void
    {
        Schema::rename('kasir_transaksi', 'transaksis');
    }
};