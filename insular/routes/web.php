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
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/{id}', 'UserController@seeUserDetail')->name('detail');
Route::get('/users/validate/{id}', 'UserController@validateUserViaAdmin')->name('validate');

/*
|--------------------------------------------------------------------------
| TRANSACTIONS ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/transactions/','TransactionController@seeAllTransactions')->name('transactions');
Route::get('/transactions/{id}','TransactionController@seeTransactionDetail')->name('transactionDetail');
Route::get('transactions/process/{id}','TransactionController@processTransaction')->name('processTransaction');
Route::get('transactions/denegate/{id}','TransactionController@denegateTransaction')->name('denegateTransaction');
Route::get('transactions/user/{id}','TransactionController@seeTransactionsByUser')->name('transactionsByUser');

/*
|--------------------------------------------------------------------------
| EXCHANGE RATES ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/exchange_rates','ExchangeRateController@showAllExchangeRates')->name('exchange_rates');
Route::get('/exchange_rates/generate/','ExchangeRateController@generateExchangeRate')->name('generate_exchange_rate');

/*
|--------------------------------------------------------------------------
| Wallet Transactions RATES ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/wallet_transaction/getAll','WalletTransactionController@showAllMovements')->name('show_all_movements');
Route::get('/wallet_transaction/getByUser/{id}','WalletTransactionController@showMovementsPerUser')->name('movements_per_user');

Route::get('/home/shit', 'HomeController@shit')->name('shit');
