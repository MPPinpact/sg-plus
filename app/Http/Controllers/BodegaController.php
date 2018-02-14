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

use App\Models\Bodega;
use App\Models\Usuario;

class BodegaController extends Controller
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

    public function getBodega()
    {
        $model= new Bodega();
        $data['v_bodegas'] = $model->listBodega();
        $data['v_locales'] = $model->listLocales();
        $data['v_estados'] = $model->listEstados();
        return View::make('bodegas.bodegas',$data);
    }

    //Registrar o actualizar bodega
    protected function postBodega(Request $request){
        $datos = $request->all();
        $user= new Usuario();
        $model= new Bodega();
        $result['f_registro'] = $model->regBodega($datos);
        $result['v_bodegas'] = $model->listBodega();
        return $result;
    }

    //Activar / desactivar bodega
    protected function postBodegactivo (Request $request){
        $datos = $request->all();
        $model= new Bodega();
        $bodega = Bodega::find($datos['IdBodega']);
        $result['activar'] = $model->activarBodega($bodega);
        $result['v_bodegas'] = $model->listBodega();
        return $result;
    }

    // Ver detalles de los bodegas
    protected function postBodegadetalle (Request $request){
        $datos = $request->all();
        $model= new Bodega();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdBodega']);
        $result['v_productos'] = $model->localesProducto($datos['IdBodega']);
        return $result;
    }

}
