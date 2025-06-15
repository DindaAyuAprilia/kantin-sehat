<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('persediaans', function (Blueprint $table) {
            $table->string('tipe')->change(); // Ensure tipe is string
        });
    }

    public function down(): void
    {
        Schema::table('persediaans', function (Blueprint $table) {
            $table->enum('tipe', ['penambahan', 'penghapusan'])->change();
        });
    }
};