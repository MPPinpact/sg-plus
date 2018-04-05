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

use App\Models\Preventa;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Impuesto;
use App\Models\Empresa;

class VentaController extends Controller
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

    public function getVentas()
    {
        $model= new Preventa();
        $data['v_preventas'] = $model->listPreventas();
        // $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        // $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();
        return View::make('ventas.ventas',$data);
    }

    //Registrar o actualizar compra
    protected function postPreventas(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result['f_registro'] = $model->regPreventa($datos);
        $result['v_preventas'] = $model->listPreventas();
        return $result;
    }

    //Registrar o actualizar Detalle compra
    protected function postRegistrarDetallec(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result['f_registro'] = $model->regDetallePreventa($datos);
        $result['v_detalles'] = $model->getDetallesPreventa($datos['IdPreVenta2']);
        return $result;
    }
        

    //Activar / desactivar Preventa
    protected function postPreventactiva(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $compra = Preventa::find($datos['idPreVenta']);
        $result['activar'] = $model->activarPreventa($compra);
        $result['v_preventas'] = $model->listPreventas();
        return $result;
    }

    //Activar / desactivar detalle compra
    protected function postCompradetalleactiva(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $detalle = $model->getOneCompraDetalle($datos['IdDetalleCompra']);
        $result['activar'] = $model->activarCompraDetalle($detalle);
        $result['v_detalles'] = $model->getDetallesCompra($detalle[0]->IdCompra);
        return $result;
    }


    protected function postBuscarPreventa(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result['v_cabecera'] = $model->getCabeceraPreventa($datos['idPreVenta']);
        $result['v_detalles'] = $model->getDetallesPreventa($datos['idPreVenta']);
        return $result;
    }

    protected function postBuscarBodega(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result= $model->getBodegas($datos['IdLocal']);
        return $result;
    }

    protected function postBuscarCliente(Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $datos['RUT']=$model->LimpiarRut($datos['RUTCliente']);
        $result = Cliente::where('RUTCliente',$datos['RUT'])->first();
        if($result == null) { $result = '{"IdCliente":0}'; } 
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
            $model= new Preventa();
            $result['v_locales'] = $model->buscarLocales($result['busqueda']->IdEmpresa); 
        } 
        return $result;
    }

    protected function postRegistroproveedor(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $id = $model->regProveedor($datos);
        return $id;
    }

    protected function postBuscarcombos(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result = $model->buscarCombos($datos);
        return $result;   
    }

    protected function postBuscarproductos(Request $request){
        $datos = $request->all();
        $result=[];
        if(isset($datos['CodigoBarra'])){
            $result['producto'] = Producto::where('CodigoBarra',$datos['CodigoBarra'])->first();
            if($result['producto'] == null) { $result['producto'] = '{"IdProducto":0}'; }
            $model= new Preventa(); 
            $result['impuesto'] = $model->buscarImpuestos($result['producto']->IdProducto);
        }
        return $result;
    }

    protected function postBuscarDetallec(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result = $model->getOnePreventaDetalle($datos['IdDetallePreVenta']);
        return $result;
    }

    protected function postCerrarPreventa(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result = $model->cerrarPreventa($datos['IdPreVenta']);
        log::info($result);
        return $result;   
    }
}