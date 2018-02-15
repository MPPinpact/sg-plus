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

use App\Models\Impuesto;

class ImpuestoController extends Controller
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

    public function getImpuesto()
    {
        $model= new Impuesto();
        $data['v_impuestos'] = $model->listImpuesto();
        $data['v_estados'] = $model->listEstados();
        return View::make('impuestos.impuestos',$data);
    }

    //Registrar o actualizar impuesto
    protected function postImpuesto(Request $request){
        $datos = $request->all();
        $model= new Impuesto();
        $result['f_registro'] = $model->regImpuesto($datos);
        $result['v_impuestos'] = $model->listImpuesto();
        return $result;
    }

    //Activar / desactivar impuesto
    protected function postImpuestoactivo(Request $request){
        $datos = $request->all();
        $model= new Impuesto();
        $impuesto = Impuesto::find($datos['IdImpuesto']);
        $result['activar'] = $model->activarImpuesto($impuesto);
        $result['v_impuestos'] = $model->listImpuesto();
        return $result;
    }

    protected function postBuscarimpuesto(Request $request){
        $datos = $request->all();
        $model= new Impuesto();
        $impuesto = Impuesto::find($datos['IdImpuesto']);
        return $impuesto;
    }
}
