<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('saldo_kas_bulanans');
    }

    public function down()
    {
        Schema::create('saldo_kas_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan');
            $table->decimal('saldo_awal', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }
};