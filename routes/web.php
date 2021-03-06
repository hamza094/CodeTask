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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

Route::middleware(['password_expired'])->group(function () {	

Route::get('/home', 'HomeController@index')->name('home');

});

Route::get('password/expired', 'Auth\ExpiredPasswordController@expired')
 ->name('password.expired');

  Route::post('password/post_expired', 'Auth\ExpiredPasswordController@postExpired')
    ->name('password.post_expired');
 });   