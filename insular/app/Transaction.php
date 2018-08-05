<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'amount_usd',
        'movement_id',
        'user_id',
        'natural_person_id',
        'exchange_rate_id'
    ];

    public $ruleForCreate = [

        'amount_usd' => 'required',
        'user_id' => 'required',
        'exchange_rate_id' => 'required',
        'wallet_id' => 'required'

    ];


    public static function createTransaction(Request $request){
        $validatorModel = new Transaction(); /// Creamos un objeto tipo user (solo para tener una instancia y poder usar el validator.
        $validator = Validator::make($request->all(),$validatorModel->ruleForCreate); //aca le pasamos al request las reglas definidas en esta clase

        //Caso 1. Que los parametros enviados al API seran erroneos, en este caso le retornamos al usuario un JSON con los errores.
        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

    }
}
