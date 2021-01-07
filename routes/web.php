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

Route::group(['middleware' => ['auth']], function() {
    Route::get('money','GraphController@index');
});

//Graphs controller

Route::get('money_update/{id}','GraphController@edit');

//Expensis controller
Route::post('money_create','ExpensesController@store');
Route::get('money_delete/{id}','ExpensesController@destroy');

//Income controller
Route::post('income_create','IncomeController@store');
Route::get('income_delete/{id}','IncomeController@destroy');
Route::post('income_update/{id}','IncomeController@update');

//Users controller
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
