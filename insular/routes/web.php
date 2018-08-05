<?php

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


Route::get('/user', 'UserController@firstService');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/{id}', 'UserController@seeUserDetail')->name('detail');
Route::get('/users/validate/{id}', 'UserController@validateUserViaAdmin')->name('validate');
Route::get('/transactions/','TransactionController@seeAllTransactions')->name('transactions');
Route::get('/transactions/{id}','TransactionController@seeTransactionDetail')->name('transactionDetail');
Route::get('transactions/process/{id}','TransactionController@processTransaction')->name('processTransaction');
Route::get('transactions/denegate/{id}','TransactionController@denegateTransaction')->name('denegateTransaction');
Route::get('/exchange_rates','ExchangeRateController@showAllExchangeRates')->name('exchange_rates');

Route::get('/home/shit', 'HomeController@shit')->name('shit');
