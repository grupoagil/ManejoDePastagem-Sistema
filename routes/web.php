<?php

use Illuminate\Support\Facades\Route;

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
	return redirect()->route('home');
});

Auth::routes();

Route::group(['namespace' => 'Admin'],function () {
	Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
	Route::group(['middleware' => 'auth'], function () {
		Route::get('table-list', function () {
			return view('pages.table_list');
		})->name('table');

		Route::get('typography', function () {
			return view('pages.typography');
		})->name('typography');

		Route::get('icons', function () {
			return view('pages.icons');
		})->name('icons');

		Route::get('map', function () {
			return view('pages.map');
		})->name('map');

		Route::get('notifications', function () {
			return view('pages.notifications');
		})->name('notifications');

		Route::get('rtl-support', function () {
			return view('pages.language');
		})->name('language');

		Route::get('upgrade', function () {
			return view('pages.upgrade');
		})->name('upgrade');
	});

	/**
	 * Gestão de Usuários
	 */
	Route::group(['prefix' => 'users'], function () {
		Route::get('/', 'UserController@index')->name('user.index');
		Route::post('new','UserController@create')->name('user.create');
		Route::post('update/{id}','UserController@update')->name('user.update');
		Route::get('apagar/{id}','UserController@apagar')->name('user.apagar');
	});
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});