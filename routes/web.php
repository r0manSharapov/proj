<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

/*Route::get('/', function () {
    return view('welcome');
});
<<<<<<< HEAD
=======
*/
Route::get('/', 'WelcomeController@index')->name('welcome');
>>>>>>> e09ab853f1fec4e66b0c298d772a1f6b48ca99db

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware("verified");

Route::get('change-password', 'ChangePasswordController@index')->middleware("auth")->middleware("verified");
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
