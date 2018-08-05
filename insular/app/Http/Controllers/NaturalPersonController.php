<?php

namespace App\Http\Controllers;

use App\NaturalPerson;
use Illuminate\Http\Request;
use DB;

class NaturalPersonController extends Controller
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

        return NaturalPerson::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NaturalPerson  $naturalPerson
     * @return \Illuminate\Http\Response
     */
    public function show(NaturalPerson $naturalPerson)
    {
        return $naturalPerson;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NaturalPerson  $naturalPerson
     * @return \Illuminate\Http\Response
     */
    public function edit(NaturalPerson $naturalPerson)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NaturalPerson  $naturalPerson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NaturalPerson $naturalPerson)
    {

        $personUpdate = new NaturalPerson();
        $personUpdate -> legal_name = $request->only('legal_name');

        //$personUpdate->save();
        dd($personUpdate);
        die();
        //dd($request->only('legal_name'));
        //$naturalPerson->update($request->all());
        //dd($naturalPerson);
        //return response()->json($naturalPerson, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NaturalPerson  $naturalPerson
     * @return \Illuminate\Http\Response
     */
    public function updateNaturalPerson(Request $request, $naturalPersonId)
    {

        $legalName = $request->get('legal_name');
        //dd($legalName);

        $values = [
          'legal_name'=>  $request->get('legal_name'),
        ];
        DB::update('update natural_people set legal_name = \''.$legalName.'\' where id = ?', [$naturalPersonId]);

        //DB::table('natural_people')->where('id', $naturalPersonId)->update(['legal_name' => 'test']);

        $responsePerson = NaturalPerson::find($naturalPersonId);
        dd($responsePerson);
        //dd($request->only('legal_name'));
        //$personUpdate -> legal_name = 'test';//$request->only('legal_name');

        //$personUpdate->save();
        die();
        //dd($request->only('legal_name'));
        //$naturalPerson->update($request->all());
        //dd($naturalPerson);
        //return response()->json($naturalPerson, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NaturalPerson  $naturalPerson
     * @return \Illuminate\Http\Response
     */
    public function destroy(NaturalPerson $naturalPerson)
    {
        //
    }
}
