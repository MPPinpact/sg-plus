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

use App\Models\CicloFacturacion;
use App\Models\Usuario;

class CicloFacturacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCicloFacturacion()
    {
        $model= new CicloFacturacion();
        $data['v_ciclos_facturacion'] = $model->listCicloFacturacion();
        $data['v_estados'] = $model->listEstados();
        return View::make('cicloFacturacion.cicloFacturacion',$data);
    }

    //Registrar o actualizar impuesto
    protected function postCicloFacturacion(Request $request){
        $datos = $request->all();
        $model= new CicloFacturacion();
        $result['f_registro'] = $model->regCiclo($datos);
        $result['v_ciclos_facturacion'] = $model->listCicloFacturacion();
        return $result;
    }

    //Activar / desactivar impuesto
    protected function postCicloactivo(Request $request){
        $datos = $request->all();
        $model= new CicloFacturacion();
        $ciclo = CicloFacturacion::find($datos['IdCicloFacturacion']);
        $result['activar'] = $model->activarCiclo($ciclo);
        $result['v_ciclos_facturacion'] = $model->listCicloFacturacion();
        return $result;
    }

    protected function postCiclodetalle(Request $request){
        $datos = $request->all();
        $model= new CicloFacturacion();
        $ciclo = CicloFacturacion::find($datos['IdCicloFacturacion']);
        return $ciclo;
    }
	
	 protected function postGenerarEECC(Request $request){
        $datos = $request->all();
        $model= new CicloFacturacion();
		
		//log::info("Llegando....");
		
        $result['f_generacion'] = $model->generarEECC($datos);
        return $result;
    }
	
	
}
