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
    public function index(Request $request)
    {
        if (Auth::check()){
            log::info("localUsuario: " .  $request->session()->has('localUsuario') );
            log::info("perfilUsuario: " . $request->session()->has('perfilUsuario') );

            if ( $request->session()->has('localUsuario') and  $request->session()->has('perfilUsuario') ) {
                return view('home.home');

            }else{
                return view('accesos.accesos');
                
            }
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
