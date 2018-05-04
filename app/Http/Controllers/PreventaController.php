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
use App\Models\VentaCredito;
use App\Models\Producto;
use App\Models\Impuesto;
use App\Models\Empresa;

class PreventaController extends Controller
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

    public function getPreventas()
    {
        $model= new Preventa();
        $data['v_preventas'] = $model->listPreventas();
        // $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        // $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();
        return View::make('preventas.preventas',$data);
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
	
	//Registrar o Actualizar Pago
    protected function postRegistrarPagoPreVenta(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $result['f_registro'] = $model->regPagoPreVenta($datos);
        $result['v_pagos'] = $model->getDetallePago($datos['IdPreVentaPago']);
        return $result;
    }
	
	protected function postDetallePagoActiva(Request $request){
        $datos = $request->all();
		$model = new Preventa();
		
		//log::info("IdDetallePago: ". $datos['IdDetallePago']);
		
		$pago = $model->getOnePagoPreVenta($datos['IdDetallePago']);		
        $detalle = $model->activarDetallePago($datos['IdDetallePago']);
        $result['v_pagos'] = $model->getDetallePago($pago->IdPreVenta);
		
        return $result;
    }
	
	
    //Registrar Pre-Venta desde el Módulo Punto de Venta
    protected function postAddProductPreVenta(Request $request){
        $datos = $request->all();
        $model= new Preventa();
		
		/* Tengo IdPreVenta? */
		$IdPreVenta=0;
		$datos['IdPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['IdPreVenta'];
		
		//log::info("IdPreVenta: " . $IdPreVenta);
		
		if($IdPreVenta==0) {
			$PreVenta = $model->regPreVentaPuntoVenta($datos);
			$obj = json_decode($PreVenta);
			$datos['IdPreVenta']=  $obj->{'IdPreVenta'};
			$IdPreVenta=$obj->{'IdPreVenta'};
		}
		
		// //log::info("IdPreVenta: " . $IdPreVenta);
		// //log::info("IdLocalPreVenta: " . $datos['IdLocalPreVenta']);
		// //log::info("IdCajaPreVenta: " . $datos['IdCajaPreVenta']);
		
		$result['v_cabecera'] = $model->getCabeceraPreventa($IdPreVenta);
        $result['f_registro'] = $model->regDetallePreVentaPuntoVenta($datos);
        $result['v_detalles'] = $model->getDetallesPreventa($datos['IdPreVenta']);
        return $result;
    }
	
	//Recuperar Pre-Venta desde el Módulo Punto de Venta
    protected function postAddPreVentaPreVenta(Request $request){
		$datos = $request->all();
        $model= new Preventa();
		
		/* Tengo IdPreVenta? */
		$IdPreVenta=0;
		$datos['NroPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['NroPreVenta'];
		//log::info("IdPreVenta: " . $IdPreVenta);
				
		$result['f_registro'] = '{"code":200}'; 
		$result['v_cabecera'] = $model->getCabeceraPreventa($IdPreVenta);
        $result['v_detalles'] = $model->getDetallesPreventa($IdPreVenta);
		$result['v_pagos'] = $model->getDetallePago($IdPreVenta);
        return $result;
    }

	protected function postAsignarVendedor(Request $request){
        //log::info("Asignar Vendedor a Pre-Venta ");
		
		$datos = $request->all();
		//log::info("IdPreVenta: " . $datos['IdPreVenta']);
		//log::info("IdVendedor: " . $datos['IdVendedorPreVenta']);
		
		$model= new Preventa();
		$result['f_registro'] = $model->regVendedorPreVenta($datos);
		
        return $result;
    }
	
	protected function postAsignarCliente(Request $request){
        //log::info("Asignar Cliente a Pre-Venta ");
		
		$datos = $request->all();
		//log::info("IdPreVenta: " . $datos['IdPreVenta']);
		//log::info("IdCliente: " . $datos['IdClientePreVenta']);
		
		$model= new Preventa();
		$result['f_registro'] = $model->regClientePreVenta($datos);
		
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

    //Activar / desactivar detalle venta
    protected function postPreventadetalleactiva(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $detalle = $model->getOnePreventaDetalle($datos['IdDetallePreVenta']);
        $preventa = Preventa::find($detalle[0]->IdPreVenta);
        if ($preventa->EstadoPreVenta > 1){
            $result['activar'] = 204;
            $result['v_detalles'] = [];          
        }else{
            $result['activar'] = $model->activarPreVentaDetalle($detalle);
            $result['v_detalles'] = $model->getDetallesPreVenta($detalle[0]->IdPreVenta);
        }
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
		////log::info("Asignar Cliente " . $datos['RUTCliente'] ." a Pre-Venta");
		
		$venta= new VentaCredito();
        $result['v_cliente'] = $venta->getOneCliente(str_replace(".","",$datos['RUTCliente']));
		$result['v_fechas'] = $venta->calcularFechaPago($result['v_cliente']);
		
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
            if($result['producto'] == null) { 
                $result['producto']['IdProducto'] = 0;
                $result['producto']['desProducto'] = "Producto no encontrado";
                return $result;
            }
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
		
		$datos['IdPreVenta']==null ? $IdPreVenta=$datos['IdPreVenta'] : $IdPreVenta= $datos['IdPreVenta'];
		
        $resultCierrePreVenta = $model->cerrarPreventa($IdPreVenta);
		//log::info($resultCierrePreVenta);
		
		if($resultCierrePreVenta==1){						
			$result['f_registro'] = '{"code":200}'; 
		}else{
			$result['f_registro'] = '{"code":"500","des_code":"'.$resultCierrePreVenta.'"}'; 
		}
        
        return $result;   
    }
}
