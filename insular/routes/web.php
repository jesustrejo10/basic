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
/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/users', 'UserController@index')->name('users')->middleware('auth');
Route::get('/users/{id}', 'UserController@seeUserDetail')->name('detail')->middleware('auth');
Route::get('/users/validate/{id}', 'UserController@validateUserViaAdmin')->name('validate')->middleware('auth');

/*
|--------------------------------------------------------------------------
| TRANSACTIONS ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/transactions/','TransactionController@seeAllTransactions')->name('transactions')->middleware('auth');
Route::get('/transactions/{id}','TransactionController@seeTransactionDetail')->name('transactionDetail')->middleware('auth');
Route::get('transactions/process/{id}','TransactionController@processTransaction')->name('processTransaction')->middleware('auth');
Route::get('transactions/denegate/{id}','TransactionController@denegateTransaction')->name('denegateTransaction')->middleware('auth');
Route::get('transactions/user/{id}','TransactionController@seeTransactionsByUser')->name('transactionsByUser')->middleware('auth');

/*
|--------------------------------------------------------------------------
| EXCHANGE RATES ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/exchange_rates','ExchangeRateController@showAllExchangeRates')->name('exchange_rates')->middleware('auth');
Route::get('/exchange_rates/generate/','ExchangeRateController@generateExchangeRate')->name('generate_exchange_rate')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Wallet Transactions RATES ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/wallet_transaction/getAll','WalletTransactionController@showAllMovements')->name('show_all_movements')->middleware('auth');
Route::get('/wallet_transaction/getByUser/{id}','WalletTransactionController@showMovementsPerUser')->name('movements_per_user')->middleware('auth');

Route::get('/home/shit', 'HomeController@shit')->name('shit');
