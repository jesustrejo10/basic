<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\NaturalPerson;
use App\StatusPerTransaction;
use App\Transaction;
use App\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\BaseResponse;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Wallet;
use App\VenezuelanBank;

class TransactionController extends Controller
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
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function createTransaction(Request $request){

        $naturalPersonValidator =  new NaturalPerson();
        $validator = Validator::make($request->all(),$naturalPersonValidator->ruleForCreate); //aca le pasamos al request las reglas definidas en esta clase

        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }else{
            $accountType = $request->account_type;
            if($accountType != "j" && $accountType != "J" && $accountType != "n" && $accountType != "N" ){
                $response = new BaseResponse();

                //$response-> data= "[]";
                $response-> message = "The account type should be J for Juridic person or N for Natural Person.";
                $response ->status = "500";

                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }else{
                if($accountType == "j" ||$accountType == "J" ){
                    if($request->get("rif") == null){
                        $response = new BaseResponse();

                        //$response-> data= "[]";
                        $response-> message = "If the account type is Juridic the field rif is required.";
                        $response ->status = "500";

                        return json_encode($response,JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    if($request->get("cedula") == null){
                        $response = new BaseResponse();

                        //$response-> data= "[]";
                        $response-> message = "If the account type is Natural the field cedula is required.";
                        $response ->status = "500";

                        return json_encode($response,JSON_UNESCAPED_SLASHES);
                    }
                }
            }
        }

        $transactionValidator = new Transaction();
        $validator = Validator::make($request->all(),$transactionValidator->ruleForCreate);

        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }
        //Paso 3 Validamos si el balance actual de la persona abarca la cantidad que se desea transferir.
        $balance = WalletTransactionController::getTotalBalance($request->get('wallet_id'));
        if($balance < $request->get('amount_usd')){
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The actual user balance is less than the requested transaction amount";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        $walletTransaction = new WalletTransaction();
        $walletTransaction->wallet_id = $request->get('wallet_id');
        $walletTransaction->amount = $request->get('amount_usd') *-1;
        $walletTransaction->fee = $request->get('fee_amount_usd') *-1;
        $walletTransaction->total_amount = $request->get('total_amount_usd') *-1;

        if($walletTransaction->save()){

            $naturalPerson = NaturalPerson::create($request->all());

            $transaction = new Transaction();
            $transaction->amount_usd = $request->get('amount_usd');
            $transaction->user_id = $request->get('user_id');
            $transaction->exchange_rate_id = $request->get('exchange_rate_id');
            $transaction->movement_id = $walletTransaction->id;
            $transaction->natural_person_id = $naturalPerson->id;

            if($transaction->save()){
                $transaction->natural_person = $naturalPerson;
                $statusPerTransaction = new StatusPerTransaction();
                $statusPerTransaction->transaction_id = $transaction->id;
                $statusPerTransaction->transaction_status_id = 1;
                $statusPerTransaction->message ='creada';
                $statusPerTransaction->is_active = 1;

                if($statusPerTransaction->save()){
                    $response = new BaseResponse();

                    $response-> data=$transaction;
                    $response-> message = "success";
                    $response ->status = "200";

                    return json_encode($response,JSON_UNESCAPED_SLASHES);
                }else{

                    WalletTransaction::destroy($walletTransaction->id);
                    Transaction::destroy($transaction->id);

                    $response = new BaseResponse();

                    //$response-> data= "[]";
                    $response-> message = "Unexpected Error, please contact the administrator";
                    $response ->status = "500";

                    return json_encode($response,JSON_UNESCAPED_SLASHES);
                }

            }else{

                WalletTransaction::destroy($walletTransaction->id);
                $response = new BaseResponse();

                //$response-> data= "[]";
                $response-> message = "Unexpected Error, please contact the administrator";
                $response ->status = "500";

                return json_encode($response,JSON_UNESCAPED_SLASHES);

            }
        }else{
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "Unexpected Error, please contact the administrator";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

    }

    public function getTransactionById($transactionId){

        $transaction = Transaction::find($transactionId);

        if($transaction == null){
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The transaction does not exist";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        $transactionOwnerId = $transaction->user_id;
        $transactionOwner = User::find($transactionOwnerId);
        $transactionOwnerName = $transactionOwner->first_name . " ". $transactionOwner->last_name;
        $transaction->transaction_owner_name = $transactionOwnerName;
        $transaction->transactionOwner = $transactionOwner;
        $exchangeRateId = $transaction->exchange_rate_id;
        $exchangeRate = ExchangeRate::find($exchangeRateId);
        $exchangeRateValue = $exchangeRate->bsf_mount_per_dollar;


        $transaction->exchange_rate_value =$exchangeRateValue;
        $transactionBsfAmount = $exchangeRateValue * $transaction->amount_usd;

        $testNumber = number_format((float)$transactionBsfAmount, 2, '.', '');
        $transaction->total_bsf_amount = $testNumber;

        $transactionNaturalPersonId = $transaction->natural_person_id;
        $transactionNaturalPerson = NaturalPerson::find($transactionNaturalPersonId);
        $transaction -> natural_person = $transactionNaturalPerson;
        $bankId = $transaction -> natural_person->bank_id;
        $bank = VenezuelanBank::find($bankId);
        $transaction->natural_person->bank = $bank;
        $transactionStatuses = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->get();
        $transaction->history = $transactionStatuses;
        $transaction ->wallet_movement = WalletTransaction::find($transaction->movement_id);

        $transactionCurrentStatus = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->where('is_active','=','1')->first();
        $transaction->current_status = $transactionCurrentStatus;

        $response = new BaseResponse();

        $response-> data= $transaction;
        $response-> message = "success";
        $response ->status = "200";

        return json_encode($response,JSON_UNESCAPED_SLASHES);
    }

    public function getAllTransactions(){
        $transactions = Transaction::all();

        $response = new BaseResponse();

        $response-> data= $transactions;
        $response-> message = "success";
        $response ->status = "200";

        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }

    public function getTransactionByUser($userId){
        $user = User::find($userId);
        $walletTransactions = WalletTransaction::select()->where('wallet_id',$user->wallet_id)->orderByDesc('id')->get();

        //$WalletId = Wallet::select()->where('user_id',$userId)->first();

        foreach ($walletTransactions as $walletTransaction){
            $transaction = Transaction::select()->where('movement_id', $walletTransaction->id)->first();
            if($transaction != null){
              $transactionCurrentStatus = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->where('is_active','=','1')->first();

              $transaction->current_status = $transactionCurrentStatus;
              $walletTransaction->transaction = $transaction;
            }
        }

        $response = new BaseResponse();

        $response-> data= $walletTransactions;
        $response-> message = "success";
        $response ->status = "200";

        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }

    public function seeAllTransactions(){
      $transactions = Transaction::all()->sortByDesc("id");

      foreach ($transactions as $transaction){
        $transactionOwnerId = $transaction->user_id;
        $transactionOwner = User::find($transactionOwnerId);
        $transactionOwnerName = $transactionOwner->first_name . " ". $transactionOwner->last_name;
        $transaction->transaction_owner_name = $transactionOwnerName;

        $exchangeRateId = $transaction->exchange_rate_id;
        $exchangeRate = ExchangeRate::find($exchangeRateId);
        $exchangeRateValue = $exchangeRate->bsf_mount_per_dollar;

        $transaction->exchange_rate_value =$exchangeRateValue;
        $transactionBsfAmount = $exchangeRateValue * $transaction->amount_usd;
        $transaction->total_bsf_amount = $transactionBsfAmount;

        $transactionNaturalPersonId = $transaction->natural_person_id;
        $transactionNaturalPerson = NaturalPerson::find($transactionNaturalPersonId);
        $transaction -> natural_person = $transactionNaturalPerson;

        $transactionStatuses = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->where('is_active','=','1')->first();
        $transaction->history = $transactionStatuses;
      }

      return view('transactions', compact('transactions'));
    }

    public function seeTransactionDetail($transactionDetailId){

      $transaction = Transaction::find($transactionDetailId);

      $transactionOwnerId = $transaction->user_id;
      $transactionOwner = User::find($transactionOwnerId);
      $transactionOwnerName = $transactionOwner->first_name . " ". $transactionOwner->last_name;
      $transaction->transaction_owner_name = $transactionOwnerName;
      $transaction->transactionOwner = $transactionOwner;
      $exchangeRateId = $transaction->exchange_rate_id;
      $exchangeRate = ExchangeRate::find($exchangeRateId);
      $exchangeRateValue = $exchangeRate->bsf_mount_per_dollar;

      $transaction->exchange_rate_value =$exchangeRateValue;
      $transactionBsfAmount = $exchangeRateValue * $transaction->amount_usd;
      $transaction->total_bsf_amount = $transactionBsfAmount;

      $transactionNaturalPersonId = $transaction->natural_person_id;
      $transactionNaturalPerson = NaturalPerson::find($transactionNaturalPersonId);
      $transaction -> natural_person = $transactionNaturalPerson;

      $transactionStatuses = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->get();
      $transaction->history = $transactionStatuses;
      $transactionCurrentStatus = StatusPerTransaction::where('transaction_id', '=', $transaction->id)->where('is_active','=','1')->first();
      $transaction->current_status = $transactionCurrentStatus;


      return view('transaction_detail',compact('transaction'));
    }

    public function processTransaction($transactionId ,Request $request){

      if( DB::update('update status_per_transactions set is_active = 0 where transaction_id = ?' , [$transactionId])){

        $statusPerTransaction = new StatusPerTransaction();
        $statusPerTransaction->transaction_id = $transactionId;
        $statusPerTransaction->transaction_status_id = 2;
        $statusPerTransaction->message =$request->message;
        $statusPerTransaction->is_active = 1;

        if($statusPerTransaction->save()){
          return redirect('transactions/'.$transactionId);
        }
      }else{
        return redirect('transactions/'.$transactionId);
      }
    }

    public function denegateTransaction($transactionId ,Request $request){
      $transaction = Transaction::find($transactionId);
      $walletTransaction = WalletTransaction::find($transaction->movement_id);

      if( DB::update('update status_per_transactions set is_active = 0 where transaction_id = ?' , [$transactionId])){

        $statusPerTransaction = new StatusPerTransaction();
        $statusPerTransaction->transaction_id = $transactionId;
        $statusPerTransaction->transaction_status_id = 3;
        $statusPerTransaction->message =$request->message;
        $statusPerTransaction->is_active = 1;

        if($statusPerTransaction->save()){

          $refundWalletTransaction = new WalletTransaction();
          $refundWalletTransaction->wallet_id = $walletTransaction->wallet_id;
          $refundWalletTransaction->amount = $walletTransaction->amount *-1;
          $refundWalletTransaction->fee = $walletTransaction->fee *-1;
          $refundWalletTransaction->total_amount = $walletTransaction->total_amount *-1;
          $refundWalletTransaction->refund = 1;
          $refundWalletTransaction->wallet_transaction_id_refund = $walletTransaction->id;
          $refundWalletTransaction->save();

          return redirect('transactions/'.$transactionId);
        }else{
          dd($transaction);
        }
      }else{
        dd()
        //return redirect('transactions/'.$transactionId);
      }

    }
}
