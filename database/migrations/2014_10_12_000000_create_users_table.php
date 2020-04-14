<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama',50);
            $table->string('email',50);
            $table->string('phone',20);
            $table->char('jenis_kelamin',1);
            $table->text('alamat_asal');
            $table->text('alamat_sekarang');
            $table->date('tgl_lahir');
            $table->string('pekerjaan',50);
            $table->string('no_ktp',20);
            $table->string('agama',10);
            $table->string('api_token');
            $table->string('profile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
