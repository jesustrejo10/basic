<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Wallet extends Model
{
    //

    protected $fillable = ['total_balance','user_id'];

    public static function generateWallet(){

        return Wallet::create(['total_balance' => 0]);

    }
}
