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

use App\Models\CajaDiaria;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Usuario;
use App\Models\Producto;

class PuntoVentaController extends Controller
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

    public function getPuntoVenta()
    {
		$IdUsuario = Auth::id();
		$IdLocal = 7;
		
        $modelCD = new CajaDiaria();
        $data['v_puntoVenta'] = array();
		
		$data['_usuarioActual_']= Usuario::find($IdUsuario);
		$data['_localActual_']= Usuario::find($IdLocal);
		$data['_cajaActual_']= $modelCD->getCajaActivaLocal($IdLocal);
		
        $data['v_formas_pago'] = $modelCD->listFormasPago();
        return View::make('puntoVenta.puntoVenta',$data);;
    }
	
	 public function postInfoCajaDiaria()
    {
		log::info("postInfoCajaDiaria");
		
		$IdUsuario = Auth::id();
		$IdLocal = 7;
		
        $modelCD = new CajaDiaria();
		$result['v_cajaActual']= $modelCD->getCajaActivaLocal($IdLocal);
	
        return $result;
    }
    
    public function getCajaDiaria()
    {
        $modelCD = new CajaDiaria();
        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias();
		
		//log::info($data['v_cajas_diarias']);
		
        return View::make('puntoVenta.cajaDiaria',$data);
    }
	
    public function getCajaDiariaResumen(Request $request){
        $datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$IdLocal = 7;
		$v_cajaActual = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($v_cajaActual);
		
		$data['v_cajaActual'] = $v_cajaActual;
		$data['v_resumen_caja'] = $modelCD->listResumenCajasDiaria($obj[0]->IdCaja);
		$data['v_recaudacion_caja_diaria'] = $modelCD->listResumenRecaudacionCajasDiaria($obj[0]->IdCaja);
		$data['v_detalle_pagos_caja_diaria'] = $modelCD->listDetallePagoCajasDiaria($obj[0]->IdCaja);
		
        return View::make('puntoVenta.cajaDiariaResumen',$data);
    }
	
	public function getCajaDiariaCierre(Request $request){
        $datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$IdLocal = 7;
		$v_cajaActual = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($v_cajaActual);
		
		$data['v_cajaActual'] = $v_cajaActual;
		$data['v_resumen_caja'] = $modelCD->listResumenCajasDiaria($obj[0]->IdCaja);
		$data['v_recaudacion_caja_diaria'] = $modelCD->listResumenRecaudacionCajasDiaria($obj[0]->IdCaja);
		$data['v_detalle_pagos_caja_diaria'] = $modelCD->listDetallePagoCajasDiaria($obj[0]->IdCaja);
		
        return View::make('puntoVenta.cajaDiariaCierre',$data);
    }
	
	public function postCajaDiariaCierre(Request $request){
        $IdLocal = 7;
		
		$datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$IdCaja = $datos['IdCaja'];
		$data['cerrarCaja'] =  $modelCD->cerrarCajaDiaria($IdCaja);
		$cierreCaja = $modelCD->abrirCajaDiaria($IdLocal);
		
		$data['v_cajaActual'] = $modelCD->getCajaActivaLocal($IdLocal);
		
		return $data;
		
        //return View::make('puntoVenta.cajaDiariaCierre',$data);
    }

    public function postCajaDiariaResumen(Request $request){
        $datos = $request->all();
        $modelCD = new CajaDiaria();
        $result = $modelCD->listCajasDiariasResumen($datos['IdCaja']);
        return $result;
    }
	
	/* Fecha: 2018-04-21 :: AAA */
	public function postDetalleVentaFormaPago(Request $request){
		//log::info("postDetalleVentaFormaPago");
		
        $datos = $request->all();
        $modelCD = new CajaDiaria();
		
		$IdLocal = $datos['IdLocal'];
		$IdCaja = $datos['IdCaja'];
		$IdFormaPago = $datos['IdFormaPago'];
		
		// log::info("IdLocal: " . $IdLocal);
		// log::info("IdCaja: " . $IdCaja);
		// log::info("IdFormaPago: " . $IdFormaPago);
		
        $result = $modelCD->listDetalleVentaFormaPago($IdCaja, $IdFormaPago);
        return $result;
    }
	
	
	
	public function getCajaDiariaResumenVenta()
	{
		$modelCD = new CajaDiaria();
		$IdLocal = 7;
		$data['v_cajaActual'] = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($data['v_cajaActual']);
		
		$data['v_detalle_venta'] = $modelCD->listDetalleVentaCajaDiaria($obj[0]->IdCaja);        

        return View::make('puntoVenta.cajaDiariaResumenVenta',$data);
	}
	
	public function getCajaDiariaDetalle()
	{
		$modelCD = new CajaDiaria();
        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias();
		log::info($data['v_cajas_diarias']);
        return View::make('puntoVenta.cajaDiariaDetalle',$data);
	}
	
	public function getCajaDiariaDetalleVenta()
	{
		$modelCD = new CajaDiaria();
        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias();
		log::info($data['v_cajas_diarias']);
        return View::make('puntoVenta.cajaDiariaDetalleVenta',$data);
	}
	
	public function postDetalleVenta(Request $request){
		$datos = $request->all();
		$modelVTA = new Venta();
		
		$result['v_detalle_venta'] = $modelVTA->getDetallesVenta($datos['IdVenta']);
		
        return $result;
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
        

    //Activar / desactivar Venta
    protected function postVentaActiva(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $compra = Venta::find($datos['IdVenta']);
        $result['activar'] = $model->activarVenta($compra);
        $result['v_ventas'] = $model->listVentas();
        return $result;
    }

    //Activar / desactivar detalle compra
    protected function postCompradetalleactiva(Request $request){
        $datos = $request->all();
        $model= new Venta();
		$detalle = $model->getOneCompraDetalle($datos['IdDetalleCompra']);
        $result['activar'] = $model->activarCompraDetalle($detalle);
        $result['v_detalles'] = $model->getDetallesCompra($detalle[0]->IdCompra);
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
	
	protected function postDetallePagoActiva(Request $request){
        $datos = $request->all();
		$model = new Venta();
		log::info("IdDetallePago: ". $datos['IdDetallePago']);
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
		log::info($datos);
		log::info("En el controller...");
		log::info("Inicio Función Finaliza Venta: " . $IdVenta );
		$finalizaVenta = $model->regFinalizarVenta($IdVenta);
		//log::info($finalizaVenta);
		log::info("FIn Función Finaliza Venta: " . $IdVenta);
        return;
    }
	
    protected function postBuscarVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result['v_cabecera'] = $model->getCabeceraVenta($datos['IdVenta']);
        $result['v_detalles'] = $model->getDetallesVenta($datos['IdVenta']);
		$result['v_pagos'] = $model->getDetallePago($datos['IdVenta']);
		
		log::info($result['v_pagos']);
        return $result;
    }

    protected function postBuscarBodega(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result= $model->getBodegas($datos['IdLocal']);
        return $result;
    }

    protected function postBuscarCliente(Request $request){
        log::inf0("Buscar cliente PuntoVentaController --> buscarCDC");
		
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
        $result = $model->cerrarVenta($datos['IdVenta']);
        log::info($result);
        return $result;   
    }

    protected function postBuscarClienteDetalleCredito(Request $request){
        $datos= $request->all();
        $model= new Usuario();
        $datos['RUTCliente']=$model->LimpiarRut($datos['RUTCliente']);
        $model= new Cliente();
        $result['v_cliente'] = $model->buscarClienteDetalleCredito($datos);
        return $result;
    }

    protected function postPagarCuenta(Request $request){
        $datos = $request->all();
        log::info($datos);
        return $datos;
    }

    protected function postBuscarProductosC(Request $request){
        $datos = $request->all();
        $producto = Producto::where('CodigoBarra', '=', $datos['CodigoProducto'])->first();
        $result['Existe'] = 0;
		
        if ($producto != null){
            $result['Existe'] = 1;
            $model= new Producto();
            $result['v_stock'] = $model->listStock($producto->IdProducto);
        }
		
        return $result;
    }
    

}