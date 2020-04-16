<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
   public function home(){
       return view('pages.home');
   }

   public function login(){
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
       /*$level = ['key' => [
            'admin',
            'pengurus',
            'user',],
            'value'=>[
                'Admin',
                'Pengurus',
                'User',
            ]
       ];
       $level = array(
           'key'=>['admin','pengurus','user'],
           'value'=>['Admin','Pengurus','User'],
       );
      */
     
       $level[] = (object) ["key"=>"admin", "value"=>"Admin"];
       $level[] = (object) ["key"=>"pengurus", "value"=>"Pengurus"];
       $level[] = (object) ["key"=>"user", "value"=>"User"];
      
       //dd($level);
    return view('pages.edituser',['user'=>$user, 'level'=>$level]);
   }
}
