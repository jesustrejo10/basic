<?php

namespace App\Http\Controllers;
use App\BaseResponse;
use App\ExchangeRate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = new BaseResponse();

        $response ->status = "200";
        $response-> message = "success";
        $response-> data= ExchangeRate::all();


        return json_encode($response,JSON_UNESCAPED_SLASHES);
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
        $modelExchangeRate = new ExchangeRate();
        $validaExchangeRate = $modelExchangeRate->createValidatedInstance($request);

        return $validaExchangeRate;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function show(ExchangeRate $exchangeRate)
    {
        return $exchangeRate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate = ExchangeRate::findOrFail($exchangeRate);
        //if($exchangeRate)
          //  $exchangeRate->delete();

        //$exchangeRate = ExchangeRate::where('id', $exchangeRate)->get();
          //  if($exchangeRate)
            //    $exchangeRate->delete();

        return $exchangeRate;
    }

    public function getLastExhangeRate(){
        $lastExchangerate =  DB::table('exchange_rates')->orderBy('id', 'desc')->first();

        $response = new BaseResponse();

        $response ->status = "200";
        $response-> message = "success";
        $response-> data= $lastExchangerate;


        return json_encode($response,JSON_UNESCAPED_SLASHES);
    }

    public function showAllExchangeRates(){
      $exchangeRates = ExchangeRate::all();

      return view('exchange_rates', compact('exchangeRates'));
    }

    public function generateExchangeRate(Request $request){

        $validatorModel = new ExchangeRate;
        $validator = Validator::make($request->all(),$validatorModel->ruleForCreate);
        if( $validator->fails() )
        {
            $error = true;
            return redirect('exchange_rates');

            //return view('exchange_rates', compact('error'));
        }
        else
        {
          $exchangeRate = ExchangeRate::create($request->all());
            $error = false;
            return redirect('exchange_rates');

            //return view('exchange_rates', compact('error'));
        }

    }
}
