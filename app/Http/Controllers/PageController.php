<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
