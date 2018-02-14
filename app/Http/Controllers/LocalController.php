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

use App\Models\Local;
use App\Models\Usuario;

class LocalController extends Controller
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

    public function getLocal()
    {
        $model= new Local();
        $data['v_locales'] = $model->listLocal();
        $data['v_empresas'] = $model->listEmpresas();
        $data['v_estados'] = $model->listEstados();
        return View::make('locales.locales',$data);
    }

    //Registrar o actualizar local
    protected function postLocal(Request $request){
        $datos = $request->all();
        $user= new Usuario();
        $model= new Local();
        $result['f_registro'] = $model->regLocal($datos);
        $result['v_locales'] = $model->listLocal();
        return $result;
    }

    //Activar / desactivar local
    protected function postLocalactivo (Request $request){
        $datos = $request->all();
        $model= new Local();
        $empresa = Local::find($datos['IdLocal']);
        $result['activar'] = $model->activarLocal($empresa);
        $result['v_locales'] = $model->listLocal();
        return $result;
    }

    // Ver detalles de los locales
    protected function postLocaldetalle (Request $request){
        $datos = $request->all();
        $model= new Local();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdLocal']);
        $result['v_bodegas'] = $model->bodegasLocal($datos['IdLocal']);
        return $result;
    }

}
