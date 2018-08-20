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

      $transactionMovementProfit = WalletTransaction::select()->where('total_amount','<','0')->get();
      $totalFee = 0;
      $totalAmount = 0;
      foreach($transactionMovementProfit as $movement){
          $totalFee = $totalFee + $movement->fee;
          $totalAmount = $totalAmount+ $movement->total_amount;
      }
      $totalAmount = $totalAmount *-1;
      $totalFee = $totalFee *-1;


      $depositMovementProfit = WalletTransaction::select()->where('total_amount','>','0')->where('refund','=','0')->get();
      $totalDeposit = 0;
      foreach($depositMovementProfit as $movement){
          $totalDeposit = $totalDeposit + $movement->total_amount;
      }

      

      //dd($depositMovementProfit);
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

      $depositMovements = WalletTransaction::select()->where('total_amount','>','0')->where('status','1')->take(10)->orderBy('id','desc')->get();

      foreach($depositMovements as $movement) {
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

      $c=[];
      $d=[];
      foreach ($depositMovements as $movement) {
        array_push($c,"D");
        array_push($d,$movement->total_amount);
        // code...
      }

      return view('home',compact('a','b','c','d','totalFee','totalAmount','totalDeposit','usersPendingToValidate','pendingTransactionsAmount','finalMount'));

    }

    public function shit()
    {
        return 'SHIT';
    }
}
