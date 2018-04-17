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
        $data['v_formas_de_pago'] = $model->listFormasPago();
        return View::make('formaspago.formaspago',$data);
    }

    //Registrar o actualizar proveedor
    protected function postFormaPago(Request $request){
        $datos = $request->all();
        $model= new FormaPago ();
        $result['f_registro'] = $model->regFormaPago($datos);
        $result['v_formas_de_pago'] = $model->listFormasPago();
        return $result;
    }

    //Activar / desactivar proveedor
    protected function postFormaPagoactivo (Request $request){        
        $datos = $request->all();
        $model= new FormaPago();
        $proveedor = FormaPago::find($datos['IdFormaPago']);
        $result['activar'] = $model->activarFormaPago($proveedor);
        $result['v_formas_de_pago'] = $model->listFormasPago();
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





