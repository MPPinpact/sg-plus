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

use App\Models\Compra;

class CompraController extends Controller
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

    public function getCompras()
    {
        $model= new Compra();
        $data['v_compras'] = $model->listCompra();
        $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        return View::make('compras.compras',$data);
    }

    //Registrar o actualizar impuesto
    protected function postCompras(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result['f_registro'] = $model->regCompra($datos);
        $result['v_compras'] = $model->listCompra();
        return $result;
    }

    //Activar / desactivar impuesto
    protected function postCompractiva(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $compra = Compra::find($datos['IdCompra']);
        $result['activar'] = $model->activarCompra($compra);
        $result['v_compras'] = $model->listCompra();
        return $result;
    }

    protected function postBuscarcompra(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result['v_cabecera'] = $model->getCabeceraCompra($datos['IdCompra']);
        $result['v_detalles'] = $model->getDetallesCompra($datos['IdCompra']);
        return $result;
    }
}
