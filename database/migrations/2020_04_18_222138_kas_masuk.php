<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KasMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas_masuk', function (Blueprint $table) {
            $table->uuid('id_masuk')->primary();
            $table->uuid('id_input');
            $table->foreign('id_input')->references('id')->on('users');
            $table->uuid('id_warga');
            $table->foreign('id_warga')->references('id')->on('users');
            $table->date('tgl_bayar');
            $table->string('jenis', 50);
            $table->decimal('jumlah',18,2);
            $table->string('periode',10);
            $table->string('keterangan',100)->nullable();
            $table->date('tgl_closing')->nullable();
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
        Schema::dropIfExists('kas_masuk');
    }
}
