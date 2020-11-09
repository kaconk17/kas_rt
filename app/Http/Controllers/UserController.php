<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\LogModel;

class UserController extends Controller
{
   public function postreg(Request $request){
        $request->validate([
            'nama' =>'required|min:3',
            'password'=>'required|min:6',
            'email'=>'required',
            'telepon'=>'required|numeric|min:6',
            'ktp'=>'required|numeric|min:6',
            'tgl_lahir'=>'required|date',
            'kelamin'=>'required',
            'agama'=>'required',
            'level'=>'required',
        ]);

        $user = new User();
        $user->id = Str::uuid();
        $user->nama = $request['nama'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->phone = $request['telepon'];
        $user->jenis_kelamin = $request['kelamin'];
        $user->alamat_asal = $request['alamat_asal'];
        $user->alamat_sekarang = $request['alamat_sekarang'];
        $user->tgl_lahir = $request['tgl_lahir'];
        $user->pekerjaan = $request['pekerjaan'];
        $user->no_ktp = $request['ktp'];
        $user->agama = $request['agama'];
        $user->level = $request['level'];
        $saved = $user->save();

        if (!$saved) {
            Session::flash('alert-danger','Register gagal !'); 
            return redirect()->route('user');
        }
        $user->rollApiKey();
        Session::flash('alert-success','Register berhasil !'); 
        return redirect()->route('user');
   }

   public function list(Request $request){

    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $Datas = User::where('nama','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%')
                    ->skip($start)
                    ->take($length)
                    ->get();

    $count = User::where('nama','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%')
                    ->skip($start)
                    ->take($length)
                    ->count();

    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];

   }

   public function postedit(Request $request){

        $user = User::find($request['id']);
        $user->email = $request['email'];
        $user->phone = $request['telepon'];
        $user->no_ktp = $request['ktp'];
        $user->alamat_asal = $request['alamat_asal'];
        $user->alamat_sekarang = $request['alamat_sekarang'];
        $user->pekerjaan = $request['pekerjaan'];
        $user->level = $request['level'];

        if ($user->isDirty()) {
           
            $user->save();
            $message ="edit: user, ID : ".$request['id'];
            $data = [
                'id_log' => Str::uuid(),
                'id_user' => Session::get('id'),
                'activity' =>"edit",
                'message' => $message,
            ];
        LogModel::create($data);
            Session::flash('alert-success','Update berhasil !'); 
        }else{
            Session::flash('alert-danger','Data tidak diupdate !'); 
        }

        
        return redirect()->route('user');
   }

   public function postlogin(Request $request){
    

    $data = User::where('email',$request['email'])->first();
  
    if ($data) {
       if (Hash::check($request['password'],$data->password)) {
        Session::put('name',$data->nama);
        Session::put('id',$data->id);
        Session::put('level',$data->level);
        Session::put('login',true);
        $request->session()->save();
            $data->rollApiKey(); //Model Function

            return array(
                'user' => $data,
                'token'=>base64_encode($data->api_token),
                'message' => 'Authorization Successful!',
                'success'=>true
            );

       }else{
        
        Session::flash('alert','Password atau email salah !'); 
        return array(
            'message' => 'Authorization failed!',
            'success'=>false
        );
       
       }
    }else{
        Session::flash('alert','Password atau email salah !'); 
       return array(
        'message' => 'Authorization failed!',
        'success'=>false
    );
    }
   }

   public function logout(Request $request){
    $request->session()->invalidate();
   
    return array(
        
        'message' => 'Logout Successful!',
        'success'=>true
    );
   }

   public function delete(Request $request){

        $user = User::find($request['id'])->delete();

        if ($user) {
           $pesan = 'Hapus Data Berhasil !';
           $res = true;
           $message ="delete: user, ID : ".$request['id'];
           $data = [
            'id_log' => Str::uuid(),
            'id_user' => Session::get('id'),
            'activity' =>"delete",
            'message' => $message,
        ];
        LogModel::create($data);
        }else{
            $pesan = 'Hapus Data Gagal !';
           $res = false;
        }

        return array(
        
            'message' => $pesan,
            'success'=>$res
        );

    }

    public function passupdate(Request $request){
        $user = User::find($request['edit-id']);

        $user->password = Hash::make($request['edit-pass']);

        if ($user->isDirty()) {
            $user->save();
            $pesan = 'Reset Password Berhasil !';
           $res = true;
        }else{
            $pesan = 'Reset Password Gagal !';
            $res = false;
        }

        return array(
        
            'message' => $pesan,
            'success'=>$res
        );
    }
}
