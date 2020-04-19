<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id_record')->primary();
            $table->uuid('id_masuk')->nullable();
            $table->foreign('id_masuk')->references('id_masuk')->on('kas_masuk')->onDelete('cascade');
            $table->uuid('id_keluar')->nullable();
            $table->foreign('id_keluar')->references('id_keluar')->on('kas_keluar')->onDelete('cascade');
            $table->string('jenis', 10);
            $table->date('tgl_keluar');
            $table->decimal('jumlah',18,2);
            $table->string('periode',10);    
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
        Schema::dropIfExists('transaksi');
    }
}
