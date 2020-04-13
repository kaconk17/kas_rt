<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
   public function home(){
       return view('layout.main');
   }

   public function login(){
       return view('layout.login');
   }
}
