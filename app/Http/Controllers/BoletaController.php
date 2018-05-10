<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Form;
use Lang;
use View;
use Redirect;
use SerializesModels;
use Log;
use Session;
use Config;
use Mail;
use Storage;
use DB;

use App\Models\Preventa;
use App\Models\Venta;
use App\Models\Boleta;

class BoletaController extends Controller
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

    //Registrar o actualizar proveedor
    protected function postBoletaVer(Request $request){
        log::info("postBoletaVer()");

        $datos = $request->all();
        if ($datos['caso']==1){
            $preventa = Preventa::find($datos['idPreVenta']);

            if($preventa->EstadoPreVenta == 2 or $preventa->EstadoPreVenta == 3){
                $model= new Boleta();
                $result['status']['code'] = 200;
                $result['status']['des_code'] = "Procesada.!";
                $result['boleta'] = $model->verBoleta($preventa,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una preventa cerrada";
            }
        }

        if ($datos['caso']==2){
            $venta = Venta::find(isset($datos['IdVenta']) ? $datos['IdVenta'] : $datos['idPreVenta'] );

            if($venta->EstadoVenta == 2 or $venta->EstadoVenta == 3){
                $model= new Boleta();
                $result['status']['code'] = 200;
                $result['status']['des_code'] = "Procesada.!";
                $result['boleta'] = $model->verBoleta($venta,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una venta cerrada";
            }
        }

        // $model= new FormaPago ();
        // $result['f_registro'] = $model->regFormaPago($datos);
        // $result['v_formas_de_pago'] = $model->listFormasPago();
        return $result;
    }

    // //Activar / desactivar proveedor
    // protected function VerificarEstado ($estado){  
    //     if ($estado == 2){
    //         return true;
    //     }else{
    //         return false;
    //     }      
    // }

    // // Ver detalles de los proveedor
    // protected function postFormaPagodetalle (Request $request){
    //     $datos = $request->all();
    //     $model= new FormaPago();
    //     $result['v_detalles'] = $model->getOneDetalle($datos['IdFormaPago']);
    //     // $result['v_productos'] = $model->localesProducto($datos['IdProveedor']);
    //     return $result;
    // }

}





