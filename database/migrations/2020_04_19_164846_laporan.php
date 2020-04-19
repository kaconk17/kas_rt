<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Laporan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid('id_laporan')->primary();
            $table->date('tgl_laporan');
            $table->uuid('id_input');
            $table->foreign('id_input')->references('id')->on('users');
            $table->string('periode', 10);
            $table->decimal('saldo_awal',18,2);
            $table->decimal('total_masuk',18,2);
            $table->decimal('total_keluar',18,2); 
            $table->decimal('saldo_akhir',18,2);   
            $table->string('keterangan',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan');
    }
}
