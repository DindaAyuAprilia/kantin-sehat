<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop kolom tipe lama dan tambahkan tipe baru
        Schema::table('persediaans', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });

        Schema::table('persediaans', function (Blueprint $table) {
            $table->enum('tipe', ['penambahan', 'penghapusan'])->default('penambahan')->after('kelola_id');
        });
    }

    public function down(): void
    {
        Schema::table('persediaans', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });

        Schema::table('persediaans', function (Blueprint $table) {
            $table->enum('tipe', ['milik', 'titipan'])->default('milik')->after('kelola_id');
        });
    }
};