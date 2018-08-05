<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\BaseResponse;

class ExchangeRate extends Model
{
    //nombre de la tabla en base de datos
	protected $table = 'exchange_rates';

	//atributo de la clase
    protected $fillable = [

        'bsf_mount_per_dollar'
    ];

    //reglas para crear un objeto de tipo ExchangeRate
    public $ruleForCreate = [

        'bsf_mount_per_dollar' => 'required'
    ];

	/**
     * Metodo encargado de generar una nueva instancia de la clase .
     * @param Request $request en esta instancia van almacenados todos los campos eviados por el POST
     * @return User|\Illuminate\Contracts\Validation\Validator
     */
    public static function createValidatedInstance(Request $request){
    // Creamos un objeto tipo exchangeRate (solo para tener una instancia y poder usar el validator).
    	$validatorModel = new ExchangeRate; 
    	//Pasamos al request las reglas definidas en esta clase
        $validator = Validator::make($request->all(),$validatorModel->ruleForCreate); 
        
        if( $validator->fails() )
        {

            $response = new BaseResponse();

            $response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        } 
        else
        {
        	$exchangeRate = ExchangeRate::create($request->all());
        	$response = new BaseResponse();

            $response-> data= $exchangeRate;
            $response-> message = "success";
            $response ->status = "200";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }
    }
}
