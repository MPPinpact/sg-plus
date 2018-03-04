<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;


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
        log::info("hola");
        if (Auth::check()){
            return view('menu.home');
        }else{
            return view('login');
        }    
    }
}
