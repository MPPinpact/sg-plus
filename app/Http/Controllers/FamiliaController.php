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

use App\Models\Familia;

class FamiliaController extends Controller
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

    public function getFamilia()
    {
        $model= new Familia();
        $data['v_familias'] = $model->listFamiliasActivas();
        $data['v_estados'] = $model->listEstados();
        return View::make('familias.familias',$data);
    }

    public function getFamiliasActivas(){
        $model= new Familia();

        $result['v_familias'] = $model->listFamiliasActivas();

        return $result;
    }

    public function getFamiliasTodas(){
        $model= new Familia();

        $result['v_familias'] = $model->listFamilia();

        return $result;
    }

    //Registrar o actualizar bodega
    protected function postFamilia(Request $request){
        $datos = $request->all();
        $model= new Familia();
        $result['f_registro'] = $model->regFamilia($datos);
        $result['v_familias'] = $model->listFamilia();
        return $result;
    }

    //Activar / desactivar bodega
    protected function postFamiliactivo(Request $request){
        $datos = $request->all();
        $model= new Familia();
        $familia = Familia::find($datos['IdFamilia']);
        $result['activar'] = $model->activarFamilia($familia);
        $result['v_familias'] = $model->listFamiliasActivas();
        return $result;
    }

    protected function postBuscarfamilia(Request $request){
        $datos = $request->all();
        $model= new Familia();
        $familia = Familia::find($datos['IdFamilia']);
        return $familia;
    }
}
