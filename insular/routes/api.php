<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 *
 */

Route::apiResource('wallets','WalletController');


/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::post('users/login','UserController@loginUser')->middleware('bearer');
Route::apiResource('users','UserController')->middleware('bearer');
Route::post('create_user','UserController@createUser');
Route::post('users/validate/{id}','UserController@requestValidateProcess')->middleware('bearer');
Route::post('users/generateUserAccount/{id}','UserController@generateUserAccount')->middleware('bearer');
Route::post('users/update/{id}','UserController@updateUserInformation')->middleware('bearer');
Route::get('users/validate/{id}','UserController@validateUser')->middleware('bearer');
Route::post('users/change_active_status/{id}','UserController@changeActiveStatus')->middleware('bearer');
Route::get('users','UserController@getAllUsers')->middleware('bearer');


/*
|--------------------------------------------------------------------------
| Exchange Rate ROUTES
|--------------------------------------------------------------------------
*/
Route::post('exchange_rate','ExchangeRateController@store')->middleware('bearer');
Route::get('exchange_rate/last','ExchangeRateController@getLastExhangeRate')->middleware('bearer');
Route::apiResource('exchange_rate','ExchangeRateController')->middleware('bearer');


/*
|--------------------------------------------------------------------------
| Transaction Rates ROUTES
|--------------------------------------------------------------------------
*/
Route::post('transactions','TransactionController@createTransaction')->middleware('bearer');
Route::get('transactions/{id}','TransactionController@getTransactionById')->middleware('bearer');
Route::get('transactions','TransactionController@getAllTransactions')->middleware('bearer');
Route::get('transactions/user/{id}','TransactionController@getTransactionByUser')->middleware('bearer');
/*
|--------------------------------------------------------------------------
| Wallet ROUTES
|--------------------------------------------------------------------------
*/
Route::post('wallet/deposit','WalletController@generateDepositRequest')->middleware('bearer');
Route::get('wallet/balance/{id}','WalletTransactionController@getBalanceByWallet')->middleware('bearer');
Route::post('wallet/request_stripe_deposit','WalletController@generateDepositStripe')->middleware('bearer');

/*
|--------------------------------------------------------------------------
| Contries ROUTES
|--------------------------------------------------------------------------
*/

Route::get('contries/list','VenezuelanBankController@getAllContries');
Route::get('banks/list','VenezuelanBankController@getAllBanks');



Route::apiResource('natural_people','NaturalPersonController');
Route::post('natural_people/{id}','NaturalPersonController@updateNaturalPerson');
