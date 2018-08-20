<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StatusPerTransaction;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\WalletTransaction;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $users = User::select()->where('in_verified_process' ,'1')->get();
      $usersPendingToValidate = count($users);

      $pendingTransactions = StatusPerTransaction::select()->where('transaction_status_id','1')->where('is_active','1')->get();
      $pendingTransactionsAmount = count($pendingTransactions);

      $lastExchangerate =  DB::table('exchange_rates')->orderBy('id', 'desc')->first();

      $baseMount = $lastExchangerate->bsf_mount_per_dollar;
      $finalMount = number_format($baseMount);

      $transactionMovements = WalletTransaction::select()->where('total_amount','<','0')->take(10)->orderBy('id','desc')->get();

      foreach($transactionMovements as $movement) {
          $user = User::select()->where('wallet_id',$movement->wallet_id)->first();
          $movement->user = $user;

          if($movement->total_amount > 0){
              if($movement->stripe_id != ""){
                  $movement->movement_type = "Deposito";
              }else{
                  $transaction = Transaction::select()->where('movement_id',$movement->wallet_transaction_id_refund)->first();
                  $movement->transaction = $transaction;
                  $movement->movement_type = "Reintegro";
              }
          }else{
              $transaction = Transaction::select()->where('movement_id',$movement->id)->first();
              $movement->transaction = $transaction;
              $movement->movement_type = "transferencia";

          }
      }

      //dd($transactionMovements);
      $a=[];
      $b=[];
      foreach ($transactionMovements as $movement) {
        array_push($a,"T");
        array_push($b,$movement->total_amount*-1);
        // code...
      }

      //dd($transactionMovements);


      return view('home',compact('a','b','usersPendingToValidate','pendingTransactionsAmount','finalMount'));

    }

    public function shit()
    {
        return 'SHIT';
    }
}
