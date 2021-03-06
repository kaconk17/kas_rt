<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\masuk;
use App\transaksi;
use App\keluar;
use App\LogModel;
use App\laporan;
use App\Traits\KasTransaction;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    use KasTransaction;
    public function cekClose($period){
        $cek = laporan::where('periode','=',$period)->count();
        if ($cek > 0) {
            return true;
        }else{
            return false;
        }
    }
   public function postmasuk(Request $request){
     
       $id = Str::uuid();
        $cek = $this->cekClose($request['periode']);
        if ($cek) {
            Session::flash('alert-danger','Simpan Data gagal !'); 
        return array(
            
            'message' => 'Simpan Data Gagal!',
            'success'=>false
        );
        }
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
        //$token = apache_request_headers();
        $token = $request->header('X-API-Key');
        $user = User::where('api_token',base64_decode($token))->first();

        if($user->level == 'admin'){
            $masuk = masuk::find($id);
            if($masuk->tgl_closing != null){
               
                $mess = 'Hapus data gagal !';
                $status = false;
            }else{

                $message ="delete: kas_masuk, ID : ".$masuk->id_masuk;
                $masuk->delete();
                $mess = 'Hapus data berhasil !';
                $status = true;
                $data = [
                    'id_log' => Str::uuid(),
                    'id_user' => $user->id,
                    'activity' =>"delete",
                    'message' => $message,
                ];
                LogModel::create($data);
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
        $trans = transaksi::where('id_masuk',$kas->id_masuk)->first();
       
        if ($user->level == 'admin' && $kas->tgl_closing == null) {
           $kas->jenis = $request['edit_jenis'];
           $kas->jumlah = $request['edit_jumlah'];
           $kas->keterangan = $request['edit_keterangan'];
           $message ="update: kas_masuk, ID : ".$request['edit_id'];
           if ($kas->isDirty('jenis')) {
               $message = $message.",jenis: ".$request['edit_jenis'];
               $trans->jenis = $request['edit_jenis'];
           }
           if ($kas->isDirty('jumlah')) {
            $message = $message.",jumlah: ".$request['edit_jumlah'];
            $trans->jumlah = $request['edit_jumlah'];
           }
           if ($kas->isDirty('keterangan')) {
            $message = $message.",keterangan: ".$request['edit_keterangan'];
            $trans->keterangan = $request['edit_keterangan'];
           }
           $kas->save();
           $trans->save();
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
        $cek = $this->cekClose($request['periode']);
        if ($cek) {
            Session::flash('alert-danger','Simpan Data gagal !'); 
        return array(
            
            'message' => 'Simpan Data Gagal!',
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

   public function edit_keluar(Request $request){
      
    $id = Session::get('id');
    $user = User::find($id);
    $kas = keluar::find($request['edit_id']);
    $trans = transaksi::where('id_keluar',$kas->id_keluar)->first();

    $s = $this->getSaldo($kas->tgl_keluar);

    if (($s['saldo'] + $kas->jumlah) - $request['edit_jumlah'] < 0) {
        return array(
            'message' => 'Saldo tidak mencukupi !',
            'success'=>false
        );
    }
   
    if ($user->level == 'admin' && $kas->tgl_closing == null) {
       
       $kas->jumlah = $request['edit_jumlah'];
       $kas->keterangan = $request['edit_keterangan'];
       $message ="update: kas_keluar, ID : ".$request['edit_id'];

       if ($kas->isDirty('jumlah')) {
        $message = $message.",jumlah: ".$request['edit_jumlah'];
        $trans->jumlah = $request['edit_jumlah'];
       }
       if ($kas->isDirty('keterangan')) {
        $message = $message.",keterangan: ".$request['edit_keterangan'];
        $trans->keterangan = $request['edit_keterangan'];
       }
       $kas->save();
       $trans->save();
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

public function delete_keluar(Request $request){
    $id = $request['id'];
    $token = $request->header('X-API-Key');
    $user = User::where('api_token',base64_decode($token))->first();

    if($user->level == 'admin'){
        $keluar = keluar::find($id);
        if($keluar->tgl_closing != null){
           
            $mess = 'Hapus data gagal !';
            $status = false;
        }else{

            $message ="delete: kas_keluar, ID : ".$keluar->id_keluar;
            $keluar->delete();
            $mess = 'Hapus data berhasil !';
            $status = true;
            $data = [
                'id_log' => Str::uuid(),
                'id_user' => $user->id,
                'activity' =>"delete",
                'message' => $message,
            ];
            LogModel::create($data);
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
public function listtrans(Request $request){
    
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $awal = $request->input("tgl_awal");
    $akhir = $request->input("tgl_akhir");

    $Datas = DB::select("select * from transaksi WHERE tgl_transaksi >= '$awal' and tgl_transaksi <= '$akhir'");

    $rows = DB::select("select * from transaksi WHERE tgl_transaksi >= '$awal' and tgl_transaksi <= '$akhir'");
    $count = count($rows);
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
}
public function listbulanan(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $Datas = DB::select("select * from laporan order by tgl_laporan asc");

    $rows = DB::select("select * from laporan order by tgl_laporan asc");
    $count = count($rows);
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
}

public function savelaporan(Request $request){
    $token = $request->header('X-API-Key');
   
    $periode = $request['periode'];
    $tanggal = $periode.'-01';
    $akhir = Carbon::create($tanggal)->endOfMonth()->format('Y-m-d');
    $user = User::where('api_token',base64_decode($token))->first();
    $cek = laporan::where('periode',$periode)->count();
    $s = $this->getSaldo($akhir);
    if ($user->level == 'admin') {
        if ($cek > 0) {
            return array(
                'message' => 'Periode sudah ada !',
                'success'=>false
            );
        }
       laporan::create([
            'id_laporan'=>Str::uuid(),
            'tgl_laporan'=> Date('Y-m-d'),
            'id_input'=> $user->id,
            'periode'=> $periode,
            'saldo_awal'=> $s['awal'],
            'total_masuk'=> $s['masuk'],
            'total_keluar'=> $s['keluar'],
            'saldo_akhir'=> $s['saldo'],
       ]);
       masuk::where('periode',$periode)->update(['tgl_closing'=>Date('Y-m-d')]);
       keluar::where('periode',$periode)->update(['tgl_closing'=>Date('Y-m-d')]);
       $data = [
        'id_log' => Str::uuid(),
        'id_user' => $user->id,
        'activity' =>"create",
        'message' => "laporan periode:".$periode,
    ];
    LogModel::create($data);
       return array(
        'message' => 'Simpan Data berhasil !',
        'success'=>true
    );
    }
    return array(
        'message' => 'Simpan Data gagal !',
        'success'=>false
    );
}
public function grafik(Request $request){
    $awal = $request['tgl_awal'];
    $akhir = $request['tgl_akhir'];
    $beg = $this->getSaldo($akhir);
    $masuk = DB::select("select sum(jumlah) as jumlah from transaksi where id_masuk is not null and tgl_transaksi >= '$awal' and tgl_transaksi <= '$akhir'")[0]->jumlah;
     if (!$masuk) {
        $masuk = 0;
     }
     $keluar = DB::select("select sum(jumlah) as jumlah from transaksi where id_keluar is not null and tgl_transaksi >= '$awal' and tgl_transaksi <= '$akhir'")[0]->jumlah;
     if (!$keluar) {
        $keluar = 0;
     }
     $end = ($beg['awal'] + $masuk) - $keluar;
     return array(
        'awal' => $beg['awal'],
        'in'=>$masuk,
        'out'=> $keluar,
        'end'=> $end
    );

}
   
}
