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
Route::post('settings', 'SettingsController@store')->name('settings')->middleware("auth");

Route::get('account/delete', 'SettingsController@delete')->middleware("auth")->middleware("verified");
Route::delete('account/delete', 'SettingsController@destroy')->name('account/delete')->middleware("auth");

Route::get('/allUsers', 'UsersListController@search')->name('allUsers')->middleware("auth")->middleware("verified");

Route::get('profile/{id}', 'UsersListController@show')->name('profile')->middleware("auth")->middleware("verified");
Route::post('/profile/{id}','HomeController@store')->name('profile')->middleware("auth")->middleware("verified");
Route::post('profile/{id}','AdminController@change')->name('change')->middleware("auth")->middleware("verified");


//mostar area privada Contas
Route::get('/contas/{user}', 'PrivateAreaController@show')->name('privateArea')
    ->middleware("auth")->middleware("verified")->middleware('can:view,user');
//adicionar contas
Route::get('/contas/{user}/addAccount', 'privateAreaController@showForm')->name('viewAddAccount');
Route::post('/contas/{user}/addAccount', 'PrivateAreaController@store')->name('addAccount');
// atualizar contas
Route::get('/contas/{user}/{conta}/updateAccount', 'privateAreaController@showForm')->name('viewUpdateAccount')->middleware('can:view,conta');
Route::post('/contas/{user}/{conta}/updateAccount', 'PrivateAreaController@updateAccount')->name('updateAccount')->middleware('can:view,conta');

//soft delete de conta
Route::delete('/contas/{conta}/softdeleted', 'ContaController@softDelete')->name('softDelete')->middleware("auth")->middleware('can:view,conta');
Route::post('/contas/{user}', 'ContaController@restore')->name('restore');
Route::delete('/contas/{conta}/delete', 'ContaController@destroy')->name('contaDelete');

//mostrar detalhes contas
Route::get('/contas/{user}/{conta}/details', 'AccountDetailsController@index')->name('accountDetails')
    ->middleware("auth")->middleware("verified")->middleware('can:view,conta');
Route::get('/contas/{user}/{conta}/details/{movement}/moreInfo', 'AccountDetailsController@showMoreInfo')->name('accountDetailsMoreInfo');
Route::get('/contas/{user}/{conta}/details/search', 'AccountDetailsController@search')->name('accountDetailsSearch')->middleware("auth")->middleware("verified");

//adicionar Movimentos
Route::get('/contas/{user}/{conta}/addMovement', 'AccountDetailsController@showForm')->name('viewAddMovement');
Route::post('/contas/{user}/{conta}/addMovement', 'AccountDetailsController@store')->name('addMovement');


// atualizar Movimentos
Route::get('/contas/{user}/{conta}/updateMovement', 'AccountDetailsController@showForm')->name('viewUpdateMovement');
Route::post('/contas/{user}/{conta}/updateMovement', 'AccountDetailsController@updateAccount')->name('updateMovement');
