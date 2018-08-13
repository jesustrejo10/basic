<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{


    protected $fillable = ['wallet_id','amount','status','fee','total_amount'];

    public $ruleForCreate =[

        'wallet_id' => 'required',
        'amount' => 'required'
    ];


}
