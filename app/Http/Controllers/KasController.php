<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\masuk;
use App\transaksi;
use App\keluar;
use App\LogModel;
use App\Traits\KasTransaction;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    use KasTransaction;
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
            Session::flash('alert-success','Simpan Data gagal !'); 
        return array(
            
            'message' => 'Simpan Data Berhasil!',
            'success'=>true
        );
       }else{
        Session::flash('alert-danger','Simpan Data gagal !'); 
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

   public function delete_masuk(Request $request){
        $id = $request['id'];
        $token = apache_request_headers();

        $user = User::where('api_token',base64_decode($token['X-API-Key']))->first();

        if($user->level == 'admin'){
            $masuk = masuk::find($id);
            if($masuk->tgl_closing != null){
               
                $mess = 'Hapus data gagal !';
                $status = false;
            }else{

                $masuk->delete();
                $mess = 'Hapus data berhasil !';
                $status = true;
            }
        }else{
            $mess = 'Hapus data gagal !';
            $status = false;
        }
        return array(
            'message' => $mess,
            'success'=>$status
        );
   }

   public function edit_masuk(Request $request){
      
        $id = Session::get('id');
        $user = User::find($id);
        $kas = masuk::find($request['edit_id']);

        if ($user->level == 'admin' && $kas->tgl_closing == null) {
           $kas->jenis = $request['edit_jenis'];
           $kas->jumlah = $request['edit_jumlah'];
           $kas->keterangan = $request['edit_keterangan'];
           $message ="update: kas_masuk, ID : ".$request['edit_id'];
           if ($kas->isDirty('jenis')) {
               $message = $message.",jenis: ".$request['edit_jenis'];
           }
           if ($kas->isDirty('jumlah')) {
            $message = $message.",jumlah: ".$request['edit_jumlah'];
           }
           if ($kas->isDirty('keterangan')) {
            $message = $message.",keterangan: ".$request['edit_keterangan'];
           }
           $kas->save();
           $mess = 'Edit data berhasil !';
            $status = true;
            $data = [
                'id_log' => Str::uuid(),
                'id_user' => $id,
                'activity' =>"update",
                'message' => $message,
            ];
            LogModel::create($data);
        }else{
            $mess = 'Edit data gagal !';
            $status = false;
        }
        return array(
            'message' => $mess,
            'success'=>$status
        );
   }

   //======================kas keluar===================================

   public function listkeluar(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $awal = $request->input("tgl_awal");
    $akhir = $request->input("tgl_akhir");

    $Datas = DB::select("select a.*, b.nama as nama from kas_keluar a join users b on a.id_input = b.id where a.tgl_keluar >= '$awal' and a.tgl_keluar <= '$akhir'");

    $rows = DB::select("select a.*, b.nama as nama from kas_keluar a join users b on a.id_input = b.id where a.tgl_keluar >= '$awal' and a.tgl_keluar <= '$akhir'");
    $count = count($rows);
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
   }

   public function postkeluar(Request $request){
   
       $s = $this->getSaldo($request['tanggal']);
        //dd($s);
        $user_id = Session::get('id');
        $id = Str::uuid();
        if ($s['saldo'] - $request['jumlah'] < 0) {
            Session::flash('alert-danger','Saldo tidak mencukupi !'); 
            return array(
                
                'message' => 'Saldo tidak mencukupi !',
                'success'=>false
            );
        }
        $insert = keluar::create([
            'id_keluar'=> $id,
            'id_input' => $user_id,
            'tgl_keluar' => $request['tanggal'],
            'jumlah'=> $request['jumlah'],
            'periode'=> $request['periode'],
            'keterangan'=> $request['desk'],
           
        ]);
        if ($insert) {
            $trans = transaksi::create([
                'id_record'=>Str::uuid(),
                'id_keluar'=>$id,
                'jenis'=>'pengeluaran',
                'tgl_transaksi'=>$request['tanggal'],
                'jumlah'=>$request['jumlah'],
                'periode'=>$request['periode'],
                'keterangan'=>$request['desk'],
            ]);
            Session::flash('alert-success','Simpan Data berhasil !'); 
            return array(
            
                'message' => 'Simpan Data Berhasil!',
                'success'=>true
            );
        }else{
            Session::flash('alert-danger','Simpan Data gagal !'); 
            return array(
                
                'message' => 'Simpan Data Gagal!',
                'success'=>false
            );
           }
   }

   
}
