<?php

namespace App\Http\Controllers;

use App\WalletTransaction;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Table;
use App\BaseResponse;
use App\User;
use App\Transaction;

class WalletTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WalletTransaction  $walletTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WalletTransaction  $walletTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WalletTransaction  $walletTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WalletTransaction  $walletTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(WalletTransaction $walletTransaction)
    {
        //
    }


    public static function getTotalBalance($walletId){

        $movements = WalletTransaction::select('amount')->where('wallet_id', $walletId)->get();
        $amount = 0;
        foreach($movements as $movement) {
            $amount = $amount + ($movement->amount);
        }

        return $amount;
    }

    public static function getBalanceByWallet($walletId){
        if($walletId == null){

            $response-> data= null;
            $response-> message = "The wallet id is required";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        $movements = WalletTransaction::select('total_amount')->where('wallet_id', $walletId)->get();

        $amount = 0;
        foreach($movements as $movement) {
            $amount = $amount + ($movement->total_amount);
        }

        $response = new BaseResponse();

        $response-> data= $amount;
        $response-> message = "success";
        $response ->status = "200";

        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }

    public static function showAllMovements(){
      $movements = WalletTransaction::all();

      foreach($movements as $movement) {
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

      //dd($movements);
      return view('wallet_transaction_list', compact('movements'));

    }

    public static function showMovementsPerUser($walletId){
        $movements = WalletTransaction::select()->where('wallet_id',$walletId)->get();
        //$movements = WalletTransaction::select()->where();

        foreach($movements as $movement) {
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

        //dd($movements);
        return view('wallet_transaction_list', compact('movements'));
    }

}
