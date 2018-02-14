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

use App\Models\Unidadmedida;
use App\Models\Usuario;

class UnidadmedidaController extends Controller
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

    public function getUnidadmedida()
    {
        $model= new Unidadmedida();
        $data['v_unidades'] = $model->listUnidad();
        $data['v_estados'] = $model->listEstados();
        return View::make('unidadmedidas.unidadmedidas',$data);
    }

    //Registrar o actualizar bodega
    protected function postUnidadmedida(Request $request){
        $datos = $request->all();
        $model= new Unidadmedida();
        $result['f_registro'] = $model->regUnidad($datos);
        $result['v_unidades'] = $model->listUnidad();
        return $result;
    }

    //Activar / desactivar bodega
    protected function postUnidadmedidactivo(Request $request){
        $datos = $request->all();
        $model= new Unidadmedida();
        $bodega = Unidadmedida::find($datos['IdUnidadMedida']);
        $result['activar'] = $model->activarUnidad($bodega);
        $result['v_unidades'] = $model->listUnidad();
        return $result;
    }
}
