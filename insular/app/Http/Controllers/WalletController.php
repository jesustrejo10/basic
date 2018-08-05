<?php

namespace App\Http\Controllers;

use App\BaseResponse;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
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
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }


    public function generateWalletInstance(Request $request){

        return Wallet::generateWallet($request);

    }

    public function generateDepositRequest(Request $request){
        $validatorModel = new WalletTransaction; /// Creamos un objeto tipo user (solo para tener una instancia y poder usar el validator.
        $validator = Validator::make($request->all(),$validatorModel->ruleForCreate); //aca le pasamos al request las reglas definidas en esta clase

        //Caso 1. Que los parametros enviados al API seran erroneos, en este caso le retornamos al usuario un JSON con los errores.
        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }else{

            $walletTransaction = new WalletTransaction($request->all());
            $walletTransaction->status = 1;
            if($walletTransaction->save()){
                $response = new BaseResponse();

                $response-> data= $walletTransaction;
                $response-> message = "success";
                $response ->status = "200";

                return json_encode($response,JSON_UNESCAPED_SLASHES);

            }else{
                $response = new BaseResponse();

                //$response-> data= "[]";
                $response-> message = "Error, please contact the admin";
                $response ->status = "500";

                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }
        }
    }
}
