<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('kasir_transaksi', 'kasir_transaksis');
    }

    public function down(): void
    {
        Schema::rename('kasir_transaksis', 'kasir_transaksi');
    }
};