<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPerTransaction extends Model
{

    protected $fillable = [
        'transaction_id',
        'transaction_status_id',
        'message',
        'is_active'
    ];
}
