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
        // Pasto
        Route::group(['prefix'=>'pastos'],function () {
            Route::post('novo', 'PastosController@novo');
            Route::get('lista', 'PastosController@lista');
        });
    });
});