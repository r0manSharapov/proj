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

Route::get('/home', 'HomeController@index')->name('home')->middleware("verified");

Route::get('change-password', 'ChangePasswordController@index')->middleware("auth")->middleware("verified");
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

Route::get('settings', 'SettingsController@index')->middleware("auth")->middleware("verified");
Route::post('settings', 'SettingsController@store')->name('settings');
Route::get('account/delete', 'SettingsController@delete')->middleware("auth")->middleware("verified");
Route::delete('account/delete', 'SettingsController@destroy')->name('account/delete');
Route::get('/allUsers', 'UsersListController@search')->name('allUsers')->middleware("verified");
Route::get('profile/{id}', 'UsersListController@show')->name('profile')->middleware("verified");
Route::post('/profile/{id}','HomeController@store')->name('profile')->middleware("verified");
Route::post('profile/{id}','AdminController@change')->name('change')->middleware("verified");
//Route::post('profile/{id}','AdminController@change')->name('type')->middleware("verified");

