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

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Models\Empresa;
use App\Models\Producto;

class CompraController extends Controller
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

    public function getCompras()
    {
        $model= new Compra();
        $data['v_compras'] = $model->listCompra();
        $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();
        return View::make('compras.compras',$data);
    }

    //Registrar o actualizar compra
    protected function postCompras(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result['f_registro'] = $model->regCompra($datos);
        $result['v_compras'] = $model->listCompra();
        return $result;
    }

    //Registrar o actualizar Detalle compra
    protected function postRegistrarDetallec(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result['f_registro'] = $model->regDetalleCompra($datos);
        $result['v_detalles'] = $model->getDetallesCompra($datos['IdCompra2']);
        return $result;
    }
        

    //Activar / desactivar compra
    protected function postCompractiva(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $compra = Compra::find($datos['IdCompra']);
        $result['activar'] = $model->activarCompra($compra);
        $result['v_compras'] = $model->listCompra();
        return $result;
    }

    //Activar / desactivar detalle compra
    protected function postCompradetalleactiva(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $detalle = $model->getOneCompraDetalle($datos['IdDetalleCompra']);
        $result['activar'] = $model->activarCompraDetalle($detalle);
        $result['v_detalles'] = $model->getDetallesCompra($detalle[0]->IdCompra);
        return $result;
    }

    protected function postBuscarcompra(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result['v_cabecera'] = $model->getCabeceraCompra($datos['IdCompra']);
        $result['v_detalles'] = $model->getDetallesCompra($datos['IdCompra']);
        return $result;
    }

    protected function postBuscarBodega(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result= $model->getBodegas($datos['IdLocal']);
        return $result;
    }

    protected function postBuscarproveedor(Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $datos['RUT']=$model->LimpiarRut($datos['RUTProveedor']);
        $result = Proveedor::where('RUTProveedor',$datos['RUT'])->first();
        if($result == null) { $result = '{"IdProveedor":0}'; } 
        return $result;
    }

    protected function postBuscarempresa(Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $datos['RUT']=$model->LimpiarRut($datos['RUTEmpresa']);
        $result['busqueda'] = Empresa::where('RUT',$datos['RUT'])->first();
        if($result['busqueda'] == null) { 
            $result['busqueda'] = '{"IdEmpresa":0}'; 
            $result['v_locales'] = [];
        }else{
            $model= new Compra();
            $result['v_locales'] = $model->buscarLocales($result['busqueda']->IdEmpresa); 
        } 
        return $result;
    }

    protected function postRegistroproveedor(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $id = $model->regProveedor($datos);
        return $id;
    }

    protected function postBuscarcombos(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result = $model->buscarCombos($datos);
        return $result;   
    }

    protected function postBuscarproductos(Request $request){
        $datos = $request->all();
        $result = Producto::where('CodigoBarra',$datos['CodigoBarra'])->first();
        if($result == null) { $result = '{"IdProducto":0}'; } 
        return $result;
    }

    protected function postBuscarDetallec(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result = $model->getOneCompraDetalle($datos['IdDetalleCompra']);
        return $result;
    }
}
