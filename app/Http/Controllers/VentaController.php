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

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Impuesto;
use App\Models\Empresa;
use App\Models\VentaCredito;
use App\Models\Preventa;

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
        $model= new Venta();
        $data['v_ventas'] = $model->listVentas();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();
        return View::make('ventas.ventas',$data);
    }

    //Registrar o actualizar compra
    protected function postVentas(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result['f_registro'] = $model->regVenta($datos);
        $result['v_ventas'] = $model->listVentas();
        return $result;
    }

    //Registrar o actualizar Detalle compra
    protected function postRegistrarDetalleVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result['f_registro'] = $model->regDetalleVenta($datos);
        $result['v_detalles'] = $model->getDetallesVenta($datos['IdVenta2']);
        return $result;
    }
	
	//Registrar Venta desde el Módulo Punto de Venta
    protected function postAddProductVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
		
		/* Tengo IdVenta? */
		$IdVenta=0;
		$datos['IdPreVenta']==null ? $IdVenta=0 : $IdVenta= $datos['IdPreVenta'];
		
		//log::info("IdVenta: " . $IdVenta);
		
		if($IdVenta==0) {
			$ResultVenta = $model->regVentaPuntoVenta($datos);
			$obj = json_decode($ResultVenta);
			$datos['IdPreVenta']=  $obj->{'IdVenta'};
			$IdVenta=$obj->{'IdVenta'};
		}
		
		//log::info("IdVenta: " . $IdVenta);
		
		$result['v_cabecera'] = $model->getCabeceraVenta($IdVenta);
        $result['f_registro'] = $model->regDetalleVentaPuntoVenta($datos);
        $result['v_detalles'] = $model->getDetallesVenta($IdVenta);
        return $result;
    }
	
	protected function postAsignarVendedor(Request $request){
        //log::info("Asignar Vendedor a Venta ");
		
		$datos = $request->all();
		//log::info("IdVenta: " . $datos['IdPreVenta']);
		//log::info("IdVendedor: " . $datos['IdVendedorPreVenta']);
		
		$model= new Venta();
		$result['f_registro'] = $model->regVendedorVenta($datos);
		
        return $result;
    }
	
	protected function postAsignarCliente(Request $request){
        //log::info("Asignar Cliente a Venta ");
		
		$datos = $request->all();
		//log::info("IdVenta: " . $datos['IdPreVenta']);
		//log::info("IdCliente: " . $datos['IdClientePreVenta']);
		
		$model= new Venta();
		$result['f_registro'] = $model->regClienteVenta($datos);
		
        return $result;
    }

    protected function postAsignarDTE(Request $request){
        //log::info("Asignar TipoDTE a Pre-Venta ");
        
        $datos = $request->all();
        //log::info("IdPreVenta: " . $datos['IdPreVenta']);
        //log::info("IdCliente: " . $datos['IdClientePreVenta']);
        
        $model= new Venta();
        $result['f_registro'] = $model->regTipoDTEVenta($datos);
        
        return $result;
    }

    //Activar / desactivar Venta
    protected function postVentaActiva(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $compra = Venta::find($datos['IdVenta']);
        $result['activar'] = $model->activarVenta($compra);
        $result['v_ventas'] = $model->listVentas();
        return $result;
    }

    //Activar / desactivar detalle venta
    protected function postventaDetallesActiva(Request $request){
        $datos = $request->all();
        $model= new Venta();
		$detalle = $model->getOneVentaDetalle($datos['IdDetalleVenta']);
        $venta = Venta::find($detalle[0]->IdVenta);
        if ($venta->EstadoVenta > 1){
            $result['activar'] = 204;
            $result['v_detalles'] = [];          
        }else{
            $result['activar'] = $model->activarVentaDetalle($detalle);
            $result['v_detalles'] = $model->getDetallesVenta($detalle->IdVenta);
        }
        return $result;
    }
	
	//Registrar o Actualizar Pago
    protected function postRegistrarPagoVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
		
        $result['f_registro'] = $model->regPagoVenta($datos);
        $result['v_pagos'] = $model->getDetallePago($datos['IdVentaPago']);
        return $result;
    }
	
	//Registrar o Actualizar Pago
    protected function postRegistrarPagoPuntoVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
		
        $result['f_registro'] = $model->regPagoPuntoVenta($datos);
        $result['v_pagos'] = $model->getDetallePago($datos['IdPreVentaPago']);
        return $result;
    }
	
	//Recuperar Pre-Venta desde el Módulo Punto de Venta
    protected function postAddPreVentaVenta(Request $request){
		$datos = $request->all();
        $model= new Preventa();
		
		/* Tengo IdPreVenta? */
		$IdPreVenta=0;
        $IdLocal=0;

		$datos['NroPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['NroPreVenta'];
        $datos['IdLocalPreVenta']==null ? $IdLocal=0 : $IdLocal= $datos['IdLocalPreVenta'];
		////log::info("IdPreVenta: " . $IdPreVenta);
		
		$model= new Venta();
		$ResultVenta = $model->cargaPreVenta($IdPreVenta, $IdLocal);
		$newVenta = json_decode($ResultVenta);
		$IdVenta = $newVenta->IdVenta;
		
		////log::info($ResultVenta);
		////log::info("IdVenta: " .$IdVenta);
		if($IdVenta!=0){
			$result['f_registro'] = '{"code":200}'; 
			$result['v_cabecera'] = $model->getCabeceraVenta($IdVenta);
			$result['v_detalles'] = $model->getDetallesVenta($IdVenta);
			$result['v_pagos'] = $model->getDetallePago($IdVenta);
		}else{
			$result['f_registro'] = '{"code":"'.$newVenta->code.'","des_code":"'.$newVenta->des_code.'"}'; 
		}
        return $result;
    }
	
	protected function postDetallePagoActiva(Request $request){
        $datos = $request->all();
		$model = new Venta();
		
		//log::info("IdDetallePago: ". $datos['IdDetallePago']);
		
		$pago = $model->getOnePagoVenta($datos['IdDetallePago']);		
        $detalle = $model->activarDetallePago($datos['IdDetallePago']);
        $result['v_pagos'] = $model->getDetallePago($pago->IdVenta);
		
        return $result;
    }
	
	protected function postCargaPreferenciasCredito(Request $request){
        $datos = $request->all();
		$modelVC = new VentaCredito();
		
		$pvr = $modelVC->listPrefenciActiva();	
		$result['v_pvc'] = $pvr;
		
        return $result;
    }
	
	protected function postFinalizarVenta(Request $request){
        $datos = $request->all();
		$model = new Venta();
		$IdVenta = $datos['IdVenta'];
		//log::info($datos);
		//log::info("En el controller...");
		//log::info("Inicio Función Finaliza Venta: " . $IdVenta );
		$result = $model->regFinalizarVenta($IdVenta);
		//log::info("FIn Función Finaliza Venta: " . $IdVenta);
        return $result;
    }
	
    protected function postBuscarVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result['v_cabecera'] = $model->getCabeceraVenta($datos['IdVenta']);
        $result['v_detalles'] = $model->getDetallesVenta($datos['IdVenta']);
		$result['v_pagos'] = $model->getDetallePago($datos['IdVenta']);
		
		//log::info($result['v_pagos']);
        return $result;
    }

    protected function postBuscarBodega(Request $request){
        $datos = $request->all();
        $model= new Venta();
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
            $model= new Venta();
            $result['v_locales'] = $model->buscarLocales($result['busqueda']->IdEmpresa); 
        } 
        return $result;
    }

    protected function postBuscarcombos(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result = $model->buscarCombos($datos);
        return $result;   
    }

    protected function postBuscarproductos(Request $request){
        $datos = $request->all();
        $result=[];
        if(isset($datos['CodigoBarra'])){
            $result['producto'] = Producto::where('CodigoBarra',$datos['CodigoBarra'])->first();
            if($result['producto'] == null) { $result['producto'] = '{"IdProducto":0}'; }
            $model= new Venta(); 
            $result['impuesto'] = $model->buscarImpuestos($result['producto']->IdProducto);
        }
        return $result;
    }

    protected function postBuscarDetalleVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result = $model->getOneVentaDetalle($datos['IdDetalleVenta']);
        return $result;
    }

    protected function postCerrarVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
		
        //Asignar TipoDTE
        $result['f_registro'] = $model->regTipoDTEVenta($datos);

		isset($datos['IdVenta']) ? $IdVenta= $datos['IdVenta'] : $IdVenta=$datos['IdPreVenta'];
		
        $resultCierreVenta = $model->cerrarVenta($IdVenta);
		//log::info($resultCierreVenta);
		
		if($resultCierreVenta==1){
			$resultFinalizaVenta = $model->regFinalizarVenta($IdVenta);
			//log::info($resultFinalizaVenta);
			$finalizaVenta = json_decode($resultFinalizaVenta);
						
			if($finalizaVenta->code==200){
				$result['f_registro'] = '{"code":200}'; 
			}else{
				$result['f_registro'] = '{"code":"'.$finalizaVenta->code.'","des_code":"'.$finalizaVenta->des_code.'"}'; 
			}
		}else{
			$result['f_registro'] = '{"code":"'.$cierreVenta->code.'","des_code":"'.$cierreVenta->des_code.'"}'; 
		}
		
        return $result;   
    }

    protected function postCargarPreventa(Request $request){
        $datos = $request->all();
        $model= new Preventa();
        $preventa = $model->getDetallesPreventa($datos['IdPreVenta']);
        if(count($preventa) > 1){
            $venta= new Venta();
            $venta->AddPreventa($datos['IdVenta'],json_decode($preventa,true));
            $result['v_detalles'] = $venta->getDetallesVenta($datos['IdVenta']);
            $result['code'] = 200;
        }else{
            $result['code'] = 204;
        }
        return $result;
    }
}