<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;
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
*/
Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware("auth")->middleware("verified");

Route::get('change-password', 'ChangePasswordController@index')->middleware("auth")->middleware("verified");
Route::post('change-password', 'ChangePasswordController@store')->name('change.password')->middleware("auth");

Route::get('settings', 'SettingsController@index')->middleware("auth")->middleware("verified");
Route::get('/privateArea', 'PrivateAreaController@index')->middleware("auth")->middleware("verified");
Route::post('settings', 'SettingsController@store')->name('settings')->middleware("auth");
Route::get('account/delete', 'SettingsController@delete')->middleware("auth")->middleware("verified");
Route::delete('account/delete', 'SettingsController@destroy')->name('account/delete')->middleware("auth");
Route::get('/allUsers', 'UsersListController@search')->name('allUsers')->middleware("auth")->middleware("verified");
Route::get('profile/{id}', 'UsersListController@show')->name('profile')->middleware("auth")->middleware("verified");
Route::post('/profile/{id}','HomeController@store')->name('profile')->middleware("auth")->middleware("verified");
Route::post('profile/{id}','AdminController@change')->name('change')->middleware("auth")->middleware("verified");

Route::post('/privateArea/addAccount', 'PrivateAreaController@store')->middleware("auth")->middleware("verified")->name('addAccount');
