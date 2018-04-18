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

use App\Models\Vendedor;
use App\Models\Usuario;
use App\Models\Preventa;



class VendedorController extends Controller
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

    public function getvendedor()
    {
        $model= new Vendedor();
        $data['v_vendedores'] = $model->listVendedor();
        $data['v_estados'] = $model->listEstados();
        return View::make('vendedores.vendedores',$data);
    }

    //Registrar o actualizar Vendedor
    protected function postvendedor(Request $request){
        $datos = $request->all();
        $datos['RUTVendedor'] = str_replace(".","", $datos['RUTVendedor']); 
		
        $model= new Vendedor();
        $result['f_registro'] = $model->regVendedor($datos);
        $result['v_vendedores'] = $model->listVendedor();
        return $result;
    }

    //Activar / desactivar Vendedor
    protected function postVendedoractivo (Request $request){
        $datos = $request->all();
        $model= new Vendedor();
        $vendedor = Vendedor::find($datos['IdVendedor']);
        $result['activar'] = $model->activarVendedor($vendedor);
        $result['v_vendedores'] = $model->listVendedor();
        return $result;
    }

    // Ver detalles de los Vendedor
    protected function postVendedordetalle (Request $request){
        $datos = $request->all();
        $model= new Vendedor();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdVendedor']);
        $result['v_metas'] = $model->listVendedorMetas($datos['IdVendedor']);
        return $result;
    }

    protected function postBuscarVen(Request $request){
        $datos = $request->all();
        $usuario= new Usuario();
		
		$rutVendedor =  str_replace(".", "", $datos['RUTVendedor']);		
        log::info("RUTVendedor: ". $rutVendedor);
		
        $result['v_usuario'] = Usuario::where('usrUserName', $rutVendedor)->first();
        return $result;
    }

    protected function postMetas(Request $request){
        $datos = $request->all();
        $preventa= new Preventa();
        $datos['PeriodoVentaInicio'] = $preventa->formatearFecha($datos['PeriodoVentaInicio']);
        $datos['PeriodoVentaFin'] = $preventa->formatearFecha($datos['PeriodoVentaFin']);
        $model= new Vendedor();
        $result['f_registro'] = $model->regMetas($datos);
        $result['v_metas'] = $model->listVendedorMetas($datos['IdVendedor2']);
        return $result;
    }

    protected function postMetaselimiar(Request $request){
        $datos = $request->all();
        $model= new Vendedor();
        $result['f_delete'] = $model->delMetas($datos['IdMeta']);
        $result['v_metas'] = $model->listVendedorMetas($datos['IdVendedor']);
        return $result;
    }

    protected function postMetasdetalles(Request $request){
        $datos = $request->all();
        $model= new Vendedor();
        $result['v_detallesM'] = $model->getOneDetalleM($datos['IdMeta']);
        return $result;
    }

}
