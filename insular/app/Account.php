<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'bank_holder_name',
        'country_id',
        'bank_name',
        'account_number',
        'aba_code',
        'bill_address'];

    public static function getRulesForCreateAccount()
    {
        $ruleForCreate = [

            'bank_holder_name' => 'required',
            'country_id' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'aba_code' => 'required',
            'bill_address' => 'required'

        ];
        return $ruleForCreate;
    }

    public static function generateUserAccount(Request $request){
        return new User($request->all());
    }

}
