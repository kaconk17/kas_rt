<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\masuk;
use App\transaksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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

       if ($masuk) {
            $trans = transaksi::create([
                'id_record'=>Str::uuid(),
                'id_masuk'=>$id,
                'jenis'=>$request['jenis'],
                'tgl_transaksi'=>$request['tanggal'],
                'jumlah'=>$request['jumlah'],
                'periode'=>$request['periode'],
                'keterangan'=>$request['keterangan'],
            ]);
        return array(
            
            'message' => 'Simpan Data Berhasil!',
            'success'=>true
        );
       }else{
        return array(
            
            'message' => 'Simpan Data Gagal!',
            'success'=>false
        );
       }
   }

   public function listiuran(Request $request){
   
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $awal = $request->input("tgl_awal");
    $akhir = $request->input("tgl_akhir");

    $Datas = DB::select("select a.*, b.nama as nama_input, c.nama as nama from kas_masuk a join users b on a.id_input = b.id join users c on a.id_warga = c.id where a.tgl_bayar >= '$awal' and a.tgl_bayar <= '$akhir'");

    $rows = DB::select("select a.*, b.nama as nama_input, c.nama as nama from kas_masuk a join users b on a.id_input = b.id join users c on a.id_warga = c.id where a.tgl_bayar >= '$awal' and a.tgl_bayar <= '$akhir'");
    $count = count($rows);
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
   }
}
