<?php

namespace App\Http\Controllers;

use App\VenezuelanBank;
use Illuminate\Http\Request;
use App\Country;
use App\BaseResponse;

class VenezuelanBankController extends Controller
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
     * @param  \App\VenezuelanBank  $venezuelanBank
     * @return \Illuminate\Http\Response
     */
    public function show(VenezuelanBank $venezuelanBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VenezuelanBank  $venezuelanBank
     * @return \Illuminate\Http\Response
     */
    public function edit(VenezuelanBank $venezuelanBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VenezuelanBank  $venezuelanBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VenezuelanBank $venezuelanBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VenezuelanBank  $venezuelanBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(VenezuelanBank $venezuelanBank)
    {
        //
    }

    public function getAllContries(){
      $CountryList = Country::all();
      $response = new BaseResponse();

      $response ->status = "200";
      $response-> message = "success";
      $response-> data= $CountryList;

      return json_encode($response,JSON_UNESCAPED_SLASHES);
    }

    public function getAllBanks(){
        $banks = VenezuelanBank::all();
        $response = new BaseResponse();

        $response ->status = "200";
        $response-> message = "success";
        $response-> data= $banks;

        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }
}
