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

use App\Models\Empresa;
use App\Models\Usuario;

class EmpresaController extends Controller
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
    public function getEmpresas()
    {
        $model= new Empresa();
        $data['v_empresas'] = $model->listEmpresa();
        $data['v_estados'] = $model->listEstados();
        return View::make('empresas.empresas',$data);
    }

    //Registrar o actualizar empresa
    protected function postEmpresas(Request $request){
        $datos = $request->all();
        $user= new Usuario();
        $datos['RUT'] = $user->LimpiarRut($datos['RUT']);
        $model= new Empresa();
        $result['f_registro'] = $model->regEmpresa($datos);
        $result['v_empresas'] = $model->listEmpresa();
        return $result;
    }

    //Activar / desactivar empresa
    protected function postEmpresactiva (Request $request){
        $datos = $request->all();
        $model= new Empresa();
        $empresa = Empresa::find($datos['IdEmpresa']);
        $result['activar'] = $model->activarEmpresa($empresa);
        $result['v_empresas'] = $model->listEmpresa();
        return $result;
    }

    // Ver detalles en las empresas
    protected function postEmpresadetalle (Request $request){
        $datos = $request->all();
        $model= new Empresa();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdEmpresa']);
        $result['v_locales'] = $model->localesEmpresa($datos['IdEmpresa']);
        return $result;
    }

}
