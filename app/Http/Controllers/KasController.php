<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\masuk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class KasController extends Controller
{
   public function postmasuk(Request $request){
      
       $id = Str::uuid();

       $masuk = masuk::create([
            'id_masuk'=>$id,
            'id_input'=>Session::get('id'),
            'id_warga'=>$request['nama'],
            'tgl_bayar'=>$request['tanggal'],
            'jenis'=>$request['jenis'],
            'jumlah'=>$request['jumlah'],
            'periode'=>$request['periode'],
            'keterangan'=>$request['keterangan'],
       ]);
   }
}
