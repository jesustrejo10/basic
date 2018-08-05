<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{


    protected $fillable = ['wallet_id','amount','status'];

    public $ruleForCreate =[

        'wallet_id' => 'required',
        'amount' => 'required'

    ];


}
