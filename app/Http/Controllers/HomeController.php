<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use App\Models\Home;

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
        if (Auth::check()){
            return view('menu.home');
        }else{
            return view('login');
        }    
    }

    public function getInfoDashboard(){
        $model= new Home();
        $result['ventaAgno'] = $model->resumenVentaLocal('Y');
        $result['ventaMes'] = $model->resumenVentaLocal('M');
        $result['ventaSemana'] = $model->resumenVentaLocal('W');
        $result['ventaDia'] = $model->resumenVentaLocal('D');

        $result['vendedores'] = $model->resumenVentaVendedores();

        return $result;
    }
}
