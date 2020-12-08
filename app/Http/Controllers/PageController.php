<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Traits\KasTransaction;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    use KasTransaction;

   public function home(){
    $s = $this->getSaldo(date('Y-m-d'));

       return view('pages.home',["saldo"=>$s['saldo'], "awal"=>$s['awal'], "masuk"=>$s['masuk'], "keluar"=>$s['keluar']]);
   }

   public function login(){

       if (Session::get('login') == True) {
            return redirect()->route('home');
       }
       return view('pages.login');
   }

   public function userlist(){
       
    return view('pages.user');
   }

   public function adduser(){
    return view('pages.adduser');
   }

   public function edituser($id){

       $user = User::find($id);
      
       $level[] = (object) ["key"=>"admin", "value"=>"Admin"];
       $level[] = (object) ["key"=>"pengurus", "value"=>"Pengurus"];
       $level[] = (object) ["key"=>"user", "value"=>"User"];
      
      
    return view('pages.edituser',['user'=>$user, 'level'=>$level]);
   }

  public function kasmasuk(){
      $users = User::all();
      return view('pages.kasmasuk',['user'=>$users]);
  }

  public function kaskeluar(){

    $s = $this->getSaldo(date('Y-m-d'));
   
    return view('pages.kaskeluar',['saldo'=>$s['saldo']]);
}
public function laporan(){
    return view('pages.laporan');
}
}
