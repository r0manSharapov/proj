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
Route::post('profile/{id}','HomeController@store')->name('profile')->middleware("auth")->middleware("verified");
Route::post('profile/{id}','AdminController@change')->name('change')->middleware("auth")->middleware("verified");

//mostar area privada Contas
Route::get('{user}/contas', 'PrivateAreaController@show')->name('privateArea')
    ->middleware("auth")->middleware("verified")->middleware('can:view,user');

Route::get('contas/addUserToAccount', 'ContaController@search')->name('addAccountToUser')->middleware("auth")->middleware("verified");



//adicionar contas
Route::get('{user}/contas/addAccount', 'privateAreaController@showForm')->name('viewAddAccount')->middleware("auth");
Route::post('{user}/contas/addAccount', 'PrivateAreaController@store')->name('addAccount');
// atualizar contas
Route::get('/contas/{user}/{conta}/updateAccount', 'privateAreaController@showForm')->name('viewUpdateAccount')->middleware('can:view,conta');
Route::post('/contas/{user}/{conta}/updateAccount', 'PrivateAreaController@updateAccount')->name('updateAccount');

//soft delete de conta links feios
Route::delete('/contas/{conta}/softdeleted', 'ContaController@softDelete')->name('softDelete')->middleware("auth")->middleware('can:view,conta');

Route::delete('/contas/delete/{conta_id}', 'ContaController@destroy')->name('delete');
Route::post('{conta_id}/contas', 'ContaController@restore')->name('restore');

//mostrar detalhes contas
Route::get('{user}/contas/{conta}/details', 'AccountDetailsController@index')->name('accountDetails')
    ->middleware("auth")->middleware("verified")->middleware('can:view,conta')->middleware('can:view,user');

//apagar movimento
Route::delete('/movimentos/delete/{movimento_id}', 'AccountDetailsController@destroy')->name('deleteMovement');

Route::get('/movimentos/{movimento}/doc', 'AccountDetailsController@show_foto')->name('accountDetailsShowPhoto')->middleware("auth")->middleware("verified");
//Alternativa contas/{conta}/movimentos/{movement}
Route::get('details/{movimento}/moreInfo', 'AccountDetailsController@showMoreInfo')->name('accountDetailsMoreInfo');
Route::get('{user}/contas/{conta}/details/search', 'AccountDetailsController@search')->name('accountDetailsSearch')->middleware("auth")->middleware("verified");

//adicionar Movimentos
Route::get('{user}/contas/{conta}/addMovement', 'AccountDetailsController@showForm')->name('viewAddMovement')->middleware("auth")->middleware('can:view,conta')->middleware('can:view,user');
Route::post('{user}/contas/{conta}/addMovement', 'AccountDetailsController@store')->name('addMovement');


// atualizar Movimentos
Route::get('{user}/contas/{conta}/updateMovement/{movimento}', 'AccountDetailsController@showForm')->name('viewUpdateMovement')->middleware("auth")->middleware('can:view,conta')->middleware('can:view,user');
Route::post('{user}/contas/{conta}/updateMovement/{movimento}', 'AccountDetailsController@updateMovement')->name('updateMovement')->middleware("auth");


//contas partilhadas buttons
Route::get('{user}/contasPartilhadas/{conta}/details', 'AccountDetailsController@index')->name('sharedAccountDetails')
    ->middleware("auth")->middleware("verified")->middleware('can:view,user')->middleware('can:view,conta');

Route::get('{user}/contasPartilhadas/{conta}/detailsRead', 'AccountDetailsController@index')->name('sharedAccountDetailsRead')
    ->middleware("auth")->middleware("verified")->middleware('can:view,user')->middleware('can:details,conta');

Route::get('/contas/{user}/{conta}/updateSharedAccount', 'privateAreaController@showForm')->name('viewSharedUpdateAccount')->middleware('can:view,user')->middleware('can:view,conta');

//partilhar conta no perfil de x user
Route::post('profile/{id}/share', 'UsersListController@shareAccount')->name('shareAccount')->middleware("auth")->middleware("verified");

//estatisticas
Route::get('{user}/financialStatistics','StatisticsController@index')->name('viewStats')->middleware('can:view,user');
Route::post('{user}/financialStatistics','StatisticsController@search')->name('searchStats')->middleware('can:view,user');

//gerir utilizadores das contas partilhadas
Route::get('contasPartilhadas/{conta}/manageUsers', 'ContaController@showManageUsers')->name('viewManageUsers')->middleware("auth")->middleware('can:view,conta');
Route::post('/contasPartilhadas/{conta_id}/updateUser', 'ContaController@updateUser')->name('updateUser');

//add user a conta partilhada
Route::get('/contasPartilhadas/{conta}/addUser', 'ContaController@showForm')->name('viewAddUser')->middleware("auth")->middleware('can:view,conta');//->middleware('can:view,conta');
Route::post('/contasPartilhadas/{conta_id}/addUser', 'ContaController@store')->name('addUser')->middleware("auth")->middleware("verified");

//remover user da conta partilhada

Route::delete('/contasPartilhadas/{conta_id}/removeUser', 'ContaController@destroyUser')->name('removeUser')->middleware("auth")->middleware("verified");;
Route::delete('/contasPartilhadas/{conta_id}/removeUser', 'ContaController@destroyUser')->name('removeUser')->middleware("auth")->middleware("verified");

