<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('ApiToken')->group(function () {
    Route::post('/list_user', 'UserController@list');
    Route::post('/listiuran', 'KasController@listiuran');
    Route::post('/kas/postmasuk', 'KasController@postmasuk');
    Route::post('/masuk/delete', 'KasController@delete_masuk');
    Route::post('/listkeluar', 'KasController@listkeluar');
    Route::post('/listtrans', 'KasController@listtrans');
    Route::post('/listbulanan', 'KasController@listbulanan');
    Route::post('/keluar/delete', 'KasController@delete_keluar');
});
