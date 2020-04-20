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
Route::get('/login', 'PageController@login')->name('login');
Route::post('/logout', 'UserController@logout');
Route::post('/postlogin', 'UserController@postlogin');
Route::group(['middleware' => ['protect:admin,pengurus,user']], function () {

    Route::get('/home', 'PageController@home')->name('home');
});

Route::group(['middleware' => ['protect:admin']], function () {

    Route::get('/user', 'PageController@userlist')->name('user');
    Route::get('/user/add', 'PageController@adduser')->name('adduser');
    Route::post('/postreg', 'UserController@postreg');
    Route::get('/user/edit/{id}', 'PageController@edituser')->name('edituser');
    Route::post('/postedit', 'UserController@postedit');
    Route::post('/user/delete', 'UserController@delete');
    Route::post('/user/passupdate', 'UserController@passupdate');
    Route::get('/kas/masuk', 'PageController@kasmasuk')->name('masuk');
    Route::get('/kas/keluar', 'PageController@kaskeluar');
    Route::post('/postmasuk', 'KasController@postmasuk');
});

