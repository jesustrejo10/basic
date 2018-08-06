<?php

namespace App\Http\Controllers;

use App\BaseResponse;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;

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


    public function generateDepositStripe(Request $request){

      $stripe = Stripe::make('sk_test_J8KTqrjMw9DUbVICSdwtDZzk');
           try {
             /*
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => '4242424242424242',
                        'exp_month' => '10',
                        'exp_year'  => '2018',
                        'cvc'       => '123',
                    ],
                ]);
                if (!isset($token['id'])) {
                    \Session::put('error','The Stripe Token was not generated correctly');
                    return ('error The Stripe Token was not generated correctly');
                }*/
                $cardToken = $request->get('token');
                $amount = $request->get('amount');

                $charge = $stripe->charges()->create([
                    'card' => $cardToken,
                    'currency' => 'USD',
                    'amount'   => $amount,
                    'description' => 'Add in wallet',
                ]);
                if($charge['status'] == 'succeeded') {

                    //Write Here Your Database insert logic.

                    \Session::put('success','Money add successfully in wallet');
                    return 'success Money add successfully in wallet';
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return 'error Money not add in wallet!! por else';
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return 'error Money not add in wallet!! por exception 1';
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return 'error Money not add in wallet!! por exception 2';
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                dd ($e);
                return 'error Money not add in wallet!! por exception 3';
            }

    }
}
