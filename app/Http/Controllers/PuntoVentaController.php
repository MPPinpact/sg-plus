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
use PDF;
use DateTime;

use CodeItNow\BarcodeBundle\Utils\QrCode;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DNS1D;

use App\Models\PuntoVenta;
use App\Models\CajaDiaria;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\AbonoCliente;
use App\Models\FormaPago;
use App\Models\Vendedor;

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

    public function getPuntoVenta(Request $request){
        // log::info("getPuntoVenta()");

		$IdUsuario = Auth::id();
        if ($request->session()->has('localUsuario')) {
            $localActual = $request->session()->get('localUsuario');
            $IdLocal = $localActual->IdLocal;
            
            $modelCD = new CajaDiaria();
            $data['v_puntoVenta'] = array();
            
            $data['_usuarioActual_']= Usuario::find($IdUsuario);
            $data['_localActual_']= Usuario::find($IdLocal);
            $data['_cajaActual_']= $modelCD->getCajaActivaLocal($IdLocal);
            
            $data['v_formas_pago'] = $modelCD->listFormasPago();
            return View::make('puntoVenta.puntoVenta',$data);;

        }else{
            return View::make('accesos.accesos');
        }
        
    }
	
	public function postInfoCajaDiaria(Request $request){
		//log::info("postInfoCajaDiaria()");
		
		$IdUsuario = Auth::id();
        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;
		
        $modelCD = new CajaDiaria();
		$result['v_cajaActual']= $modelCD->getCajaActivaLocal($IdLocal);
	
        return $result;
    }
    
    public function getCajaDiaria(Request $request){
        //log::info("getCajaDiaria()");

        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

        $modelCD = new CajaDiaria();
        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias($IdLocal);

        return View::make('puntoVenta.cajaDiaria',$data);
    }
	
    public function getCajaDiariaResumen(Request $request){
        //log::info("getCajaDiariaResumen()");

        $datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

		$v_cajaActual = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($v_cajaActual);
		
		$data['v_cajaActual'] = $v_cajaActual;
		$data['v_resumen_caja'] = $modelCD->listResumenCajasDiaria($obj[0]->IdCaja);
		$data['v_recaudacion_caja_diaria'] = $modelCD->listResumenRecaudacionCajasDiaria($obj[0]->IdCaja);
		$data['v_detalle_pagos_caja_diaria'] = $modelCD->listDetallePagoCajasDiaria($obj[0]->IdCaja);
		
        return View::make('puntoVenta.cajaDiariaResumen',$data);
    }
	
	public function getCajaDiariaCierre(Request $request){
        //log::info("getCajaDiariaCierre()");

        $datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

		$v_cajaActual = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($v_cajaActual);
		
		$data['v_cajaActual'] = $v_cajaActual;
		$data['v_resumen_caja'] = $modelCD->listResumenCajasDiaria($obj[0]->IdCaja);
		$data['v_recaudacion_caja_diaria'] = $modelCD->listResumenRecaudacionCajasDiaria($obj[0]->IdCaja);
		$data['v_detalle_pagos_caja_diaria'] = $modelCD->listDetallePagoCajasDiaria($obj[0]->IdCaja);
		
        return View::make('puntoVenta.cajaDiariaCierre',$data);
    }
	
	public function postCajaDiariaCierre(Request $request){
        //log::info("postCajaDiariaCierre()");

        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;
		
		$datos = $request->all();
		$modelCD = new CajaDiaria();
		
		$IdCaja = $datos['IdCaja'];
        $MontoCierre = $datos['MontoCierreEfectivo'];

		$data['cerrarCaja'] =  $modelCD->cerrarCajaDiaria($IdCaja, $MontoCierre);
		$cierreCaja = $modelCD->abrirCajaDiaria($IdLocal);
		
		$data['v_cajaActual'] = $modelCD->getCajaActivaLocal($IdLocal);
		
		return $data;
    }

    public function postCajaDiariaResumen(Request $request){
        //log::info("postCajaDiariaResumen()");

        $datos = $request->all();
        $modelCD = new CajaDiaria();
        $result = $modelCD->listCajasDiariasResumen($datos['IdCaja']);
        return $result;
    }
	
	public function postDetalleVentaFormaPago(Request $request){
		//log::info("postDetalleVentaFormaPago");
		
        $datos = $request->all();
        $modelCD = new CajaDiaria();
		
		$IdLocal = $datos['IdLocal'];
		$IdCaja = $datos['IdCaja'];
		$IdFormaPago = $datos['IdFormaPago'];
		
        $result = $modelCD->listDetalleVentaFormaPago($IdCaja, $IdFormaPago);
        return $result;
    }
	
	public function getCajaDiariaResumenVenta(Request $request){
		$modelCD = new CajaDiaria();
		
        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

		$data['v_cajaActual'] = $modelCD->getCajaActivaLocal($IdLocal);
		$obj = json_decode($data['v_cajaActual']);
		
		$data['v_detalle_venta'] = $modelCD->listDetalleVentaCajaDiaria($obj[0]->IdCaja);        

        return View::make('puntoVenta.cajaDiariaResumenVenta',$data);
	}
	
	public function getCajaDiariaDetalle(Request $request){
		$modelCD = new CajaDiaria();

        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias($IdLocal);
		//log::info($data['v_cajas_diarias']);
        return View::make('puntoVenta.cajaDiariaDetalle',$data);
	}
	
	public function getCajaDiariaDetalleVenta(Request $request){
		$modelCD = new CajaDiaria();
        
        $localActual = $request->session()->get('localUsuario');
        $IdLocal = $localActual->IdLocal;

        $data['v_cajas_diarias'] = $modelCD->listCajasDiarias($IdLocal);
		//log::info($data['v_cajas_diarias']);
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

		//log::info("Inicio Función Finaliza Venta: " . $IdVenta );
		$finalizaVenta = $model->regFinalizarVenta($IdVenta);		
		//log::info("FIn Función Finaliza Venta: " . $IdVenta);
        return;
    }
	
    protected function postBuscarVenta(Request $request){
        $datos = $request->all();
        $model= new Venta();
        $result['v_cabecera'] = $model->getCabeceraVenta($datos['IdVenta']);
        $result['v_detalles'] = $model->getDetallesVenta($datos['IdVenta']);
		$result['v_pagos'] = $model->getDetallePago($datos['IdVenta']);
		
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
        //log::info($result);
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
        // log::info($datos);
        $model= new Usuario();
        $datos['RUTCliente']=$model->LimpiarRut($datos['RUTClientePagoCredito']);
        $FechaNow = new DateTime();
        $model= new AbonoCliente();
        $result['data']['RUTCliente'] = $datos['RUTCliente'];
        $result['data']['MontoAnterior'] = $datos['DeudaTotalPagoCredito'];
        $result['data']['FechaAbono'] = $FechaNow->format('d-m-Y H:i');
        $result['resp'] = $model->regPagoCredito($datos);
        return $result;
    }

    protected function postReciboPago(Request $request){
        date_default_timezone_set('America/Santiago');
        $datos = $request->all();
        
        $localUsuario = Session::get('localUsuario');
        $local = DB::table('v_locales')->where('IdLocal',$localUsuario->IdLocal)->first();
        //$empresa = DB::table('v_empresas')->where('IdEmpresa',$local->IdEmpresa)->first();
        $tittle= "RECIBO DE PAGO ";  // N° ".$obj->IdVenta; 
        $IdAbono = $datos['IdAbono'];
        $cliente= new Cliente();
        $FechaNow = new DateTime();

        $abono = DB::table('v_abono_cliente')->where('IdAbono', $IdAbono)->first();
        $datos['RUTCliente'] = $abono->RUTCliente;
        $FechaAbono = new DateTime($abono->FechaAbono);

        $pdf = $cliente->buscarClienteDetalleCredito($datos);
    
        // log::info($pdf);
        // log::info($pdf['UltimoPago'][0]->MontoAbono);
        // log::info($pdf['cliente'][0]->NombreCliente);
        // log::info($pdf['cliente'] ['items']);
        // log::info($pdf['items'][0]->NombreCliente);

        $html_content = 
        '
        <div style="font-size:7px;">
            <table border="1" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:center;">
                                    '.$local->NombreLocal.'
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    '.$tittle.' '.$IdAbono.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <table border="0" cellspacing="0" width="100%" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td>
                        <b>Nombre Cliente: '.$pdf['cliente'][0]->NombreCliente.'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>RUT Cliente: '.$pdf['cliente'][0]->RUTCliente.'</b>
                    </td>
                </tr>

                <tr><td><br></td></tr> 

                <tr>
                    <td>
                        <b>Local Abono: '.$abono->NombreLocal.' </b>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Fecha Abono: '.$FechaAbono->format('d-m-Y').' '.$FechaAbono->format('H:i').' </b>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <b>Monto Abono: '.number_format($abono->MontoAbono, 0, ',', '.').' </b>
                    </td>
                </tr>

                <tr><td><br></td></tr>

                <tr>
                    <td>
                        Saldo Actual Cliente: '.number_format($pdf['DeudaTotal'][0]->CupoUtilizado, 0, ',', '.').'
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Fecha Impresión: '.$FechaNow->format('d-m-Y').' '.$FechaNow->format('H:i').' </b>
                    </td>
                </tr>
            </table>
        </div>
        ';

        $html_content .= 
        '<table border="0" cellspacing="0" width="100%" style="text-align:center;">
            <tr>
                <td width="100%">
                    <img align=center src="data:image/png;base64,'.DNS1D::getBarcodePNG($datos['IdAbono'], "C39+").'" alt="barcode"/> 
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    '.$datos['IdAbono'].'
                </td>
            </tr>
        </table>';

        PDF::SetTitle('RECIBO DE PAGO');
        $width = 80;  
        $height = 70;
        $pageLayout = array($width, $height);
        PDF::SetMargins(0, 1, 3);
        PDF::SetAutoPageBreak(TRUE, 0);
        PDF::AddPage('P',$pageLayout);
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::IncludeJS('print(true);');
        PDF::Output(uniqid().'_SamplePDF.pdf', 'I');

    }

    protected function postBuscarProductosC(Request $request){
        $datos = $request->all();
        $result['Existe'] = 0;
        $producto = Producto::where('NombreProducto', 'like', '%'. $datos['InfoProducto'] .'%')->orWhere('CodigoBarra', $datos['InfoProducto'])->orWhere('DescripcionProducto', $datos['InfoProducto'])->get();
        if ($producto != null){
            $result['Existe'] = 1;
            $model= new Producto();
            $result['v_stock'] = $model->listStock($producto[0]->IdProducto);
        }
        return $result;
    }
    
    protected function getConfigPuntoVenta(Request $request){
        $modelCD = new CajaDiaria();
        $modelFP = new FormaPago();
        $modelVDD = new Vendedor();
        $modelVTA = new Venta();

        $modelPTO = new PuntoVenta();


        if ($request->session()->has('localUsuario')) {
            $localActual = $request->session()->get('localUsuario');

            $data['v_formas_pago'] = $modelFP->listFormasPago();
            $data['v_tipo_dte'] = $modelCD->listTipoDte();
            $data['v_bodegas'] = $modelVTA->getBodegas($localActual->IdLocal);
            $data['v_vendedores'] = $modelVDD->listVendedor();
            $data['v_opciones'] = $modelPTO->listOpcionesPuntoVenta($localActual->IdLocal);

            return View::make('puntoVenta.configPuntoVenta', $data);
        }else{
            return redirect('home');
        }
    }
    
    protected function postConfigPuntoVenta(Request $request){
        $datos = $request->all();
        $modelPTO = new PuntoVenta();

        $result['f_registro'] = $modelPTO->regOpcionesPuntoVenta($datos);

        $result = '{"code":200}';

        return $result;
    }    

}