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

use App\Models\Subfamilia;

class SubfamiliaController extends Controller
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

    public function getSubamilia()
    {
        $model= new Subfamilia();
        $data['v_subfamilias'] = $model->listSubfamiliaActivas();
        $data['v_unidadmedida'] = $model->listUnidadmedida();
        $data['v_familia'] = $model->listFamilia();
        $data['v_estados'] = $model->listEstados();
        return View::make('subfamilias.subfamilias',$data);
    }

    //Registrar o actualizar Subfamilia
    protected function postSubfamilia(Request $request){
        $datos = $request->all();
        $model= new Subfamilia();
        $result['f_registro'] = $model->regSubfamilia($datos);
        $result['v_subfamilias'] = $model->listSubfamiliaActivas();
        return $result;
    }

    //Registrar o actualizar Subfamilia
    protected function postSubfamiliaActivas(Request $request){
        $datos = $request->all();
        $model= new Subfamilia();
        
        $result['v_subfamilias'] = $model->listSubfamiliaActivas();
        return $result;
    }

    //Registrar o actualizar Subfamilia
    protected function postSubfamiliaTodas(Request $request){
        $datos = $request->all();
        $model= new Subfamilia();
        
        $result['v_subfamilias'] = $model->listSubfamilia();
        return $result;
    }


    //Activar / desactivar Subfamilia
    protected function postSubfamiliactivo(Request $request){
        $datos = $request->all();
        $model= new Subfamilia();
        $subfamilia = Subfamilia::find($datos['IdSubFamilia']);
        $result['activar'] = $model->activarSubfamilia($subfamilia);
        $result['v_subfamilias'] = $model->listSubfamilia();
        return $result;
    }

    protected function postBuscarsubfamilia(Request $request){
        $datos = $request->all();
        $model= new Subfamilia();
        $subfamilia = Subfamilia::find($datos['IdSubFamilia']);
        return $subfamilia;
    }
}
