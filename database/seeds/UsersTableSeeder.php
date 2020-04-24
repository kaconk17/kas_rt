<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'id'=> Str::uuid(),
        'nama' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123456'),
        'phone' => '0033344555',
       'jenis_kelamin' => 'L',
        'alamat_asal' => 'Bangil',
        'alamat_sekarang' => 'Malang',
       'tgl_lahir' => '1988-05-03',
        'pekerjaan' => 'Guru',
        'no_ktp' => '99277788832',
        'agama' => 'Islam',
        'level' => 'admin',
       
    ]);
    }
}
