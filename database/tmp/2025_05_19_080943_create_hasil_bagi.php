<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_bagis', function (Blueprint $table) {
            $table->id();
            $table->string('tipe'); // e.g., "1000" or "2000"
            $table->timestamps();
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('hasil_bagi_id')->nullable()->after('status_titipan');
            $table->foreign('hasil_bagi_id')->references('id')->on('hasil_bagis')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['hasil_bagi_id']);
            $table->dropColumn('hasil_bagi_id');
        });

        Schema::dropIfExists('hasil_bagis');
    }
};