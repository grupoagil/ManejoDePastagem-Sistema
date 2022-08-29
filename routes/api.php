<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace'=>'Api'],function () {
    Route::post('login', 'AuthController@signin');
    Route::post('register', 'AuthController@signup');
    Route::group(['middleware' => 'auth:sanctum'],function () {
        Route::get('me', 'AuthController@me');
        Route::get('info', 'AuthController@info');
        // Pasto
        Route::group(['prefix'=>'pastos'],function () {
            Route::get('lista', 'PastosController@lista');
            Route::post('novo', 'PastosController@novo');
            Route::post('apagar', 'PastosController@apagar');
        });
        // Fazendas
        Route::group(['prefix'=>'fazendas'],function () {
            Route::get('lista', 'FazendasController@lista');
            Route::post('{id}/atualiza', 'FazendasController@atualiza');
            Route::post('novo', 'FazendasController@novo');
            Route::post('apagar', 'FazendasController@apagar');
            // Fazendas
            Route::group(['prefix'=>'{id}/piquetes'],function () {
                Route::post('atualiza', 'FazendasController@atualizaPiquete');
                Route::post('novo', 'FazendasController@addPiquete');
                Route::post('apagar', 'FazendasController@removePiquete');
            });
        });
    });
});