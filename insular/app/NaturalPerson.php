<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NaturalPerson extends Model
{
    //
    protected $table = 'natural_people';

    protected $fillable = ['legal_name','account_type','account_number','email','cedula','rif','address','bank_id','person_type'];

    public $ruleForCreate = [

        'legal_name' => 'required',
        'account_type' => 'required',
        'account_number' => 'required',
        'email' => 'required',
        'address' => 'required',
        'bank_id' => 'required'

    ];

}
