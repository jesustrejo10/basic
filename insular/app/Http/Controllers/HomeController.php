<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      $a = [1,2,3,4,5,6];
      $b = [10,20,30,40,50,60];
        return view('home',compact('a','b'));
    }

    public function shit()
    {
        return 'SHIT';
    }
}
