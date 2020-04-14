<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'PageController@home')->name('home');
Route::get('/login', 'PageController@login')->name('login');
Route::get('/user', 'PageController@userlist')->name('user');
Route::get('/user/add', 'PageController@adduser')->name('adduser');