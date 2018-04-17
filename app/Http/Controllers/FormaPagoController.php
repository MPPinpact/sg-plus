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

use App\Models\FormaPago;
// use App\Models\Proveedor;

class FormaPagoController extends Controller
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

    public function getFormaPago()
    {
        $model= new FormaPago();
        // $data['v_proveedores'] = $model->listProveedor();
        // $data['v_locales'] = $model->listLocales();
        // $data['v_estados'] = $model->listEstados();
        $data['v_formas_de_pago'] = $model->listFormaspago();
        $data['v_formas_pago'] = $model->listRegFormaspago();
        $data['v_estados'] = $model->listEstados();
        //dd($data);
        
        return View::make('formaspago.formaspago',$data);
    }

    //Registrar o actualizar proveedor
    protected function postFormaPago(Request $request){
        $datos = $request->all();
        $model= new FormaPago ();
        $result['f_registro'] = $model->regProveedor($datos);
        // $result['v_bodegas'] = $model->listProveedor();
        var_dump($result);
        return $result;
    }

    //Activar / desactivar proveedor
    protected function postFormaPagoactivo (Request $request){        
        $datos = $request->all();
        $model= new FormaPago();
        $proveedor = FormaPago::find($datos['IdFormaPago']);
        $result['activar'] = $model->activarProveedor($proveedor);
        $result['v_proveedores'] = $model->listRegFormaspago();
        // var_dump($result);
        return $result;
    }

    // Ver detalles de los proveedor
    protected function postFormaPagodetalle (Request $request){
        $datos = $request->all();
        $model= new FormaPago();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdFormaPago']);
        // $result['v_productos'] = $model->localesProducto($datos['IdProveedor']);
        return $result;
    }

}





