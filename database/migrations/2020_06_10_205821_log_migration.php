<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_log', function (Blueprint $table) {
            $table->uuid('id_log')->primary();
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('activity',10);
            $table->string('message',200)->nullable();
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
        Schema::dropIfExists('tb_log');
    }
}
