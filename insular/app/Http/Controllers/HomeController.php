<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StatusPerTransaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $users = User::select()->where('in_verified_process' ,'1')->get();
      $usersPendingToValidate = count($users);

      $pendingTransactions = StatusPerTransaction::select()->where('transaction_status_id','1')->where('is_active','1')->get();
      $pendingTransactionsAmount = count($pendingTransactions);

      $lastExchangerate =  DB::table('exchange_rates')->orderBy('id', 'desc')->first();

      $baseMount = $lastExchangerate->bsf_mount_per_dollar;
      $finalMount = number_format($baseMount);

      $a = [1,2,3,4,5,6];
      $b = [10,20,30,40,50,60];

      return view('home',compact('a','b','usersPendingToValidate','pendingTransactionsAmount','finalMount'));

    }

    public function shit()
    {
        return 'SHIT';
    }
}
