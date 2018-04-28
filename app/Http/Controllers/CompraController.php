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
use App\Models\Impuesto;

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

    public function getCompras(){
        $model= new Compra();
        $data['v_compras'] = $model->listCompra();
        $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();
        return View::make('compras.compras',$data);
    }
   
    public function getCompraMasivaNew(){
        $model= new Compra();
        $data['v_locales'] = $model->cargarLocales();
        
        $data['v_compras'] = $model->listCompra();
        $data['v_bodegas'] = $model->listBodega();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();

        $Compra = $model->getCompraMasivaAbierta(7);
        $obj = json_decode($Compra);

        if(Count($obj) > 0) $data['IdCompra'] = $obj[0]->IdCompra;
        else $data['IdCompra'] = 0;

        return View::make('compras.compraMasivaNew',$data);
    }
    
    public function getCompraMasivaList(){
        $model= new Compra();       
        $data['v_compras_masiva'] = $model->listCompraMasiva();
        return View::make('compras.compraMasivaList',$data);
    }

    public function getCompraMasivaReport(){
        $model= new Compra();
        
        $Compra = $model->getCompraMasivaAbierta(7);
        $obj = json_decode($Compra);

        if(Count($obj) > 0) $data['IdCompra'] = $obj[0]->IdCompra;
        else $data['IdCompra'] = 0;

        return View::make('compras.compraMasivaReport',$data);
    }

    public function getResumenCompra(Request $request){
        $model= new Compra();
        $datos = $request->all();

        $IdCompra = $datos['IdCompra'];
        $result['v_resumen_compra_bodega'] = $model->rerporteCompraBodega($IdCompra);
        $result['v_resumen_compra_local'] = $model->rerporteCompraLocal($IdCompra);

        return $result;
    }

    public function postCompraMasivaView(){
        $model= new Compra();
        $data['v_locales'] = $model->cargarLocales();

        return View::make('compras.compraMasivaView',$data);
    }

    public function getCompraMasivaView(Request $request){
        log::info("getCompraMasivaView()");

        $datos = $request->all();
        log::info($datos);

        $model= new Compra();

        $data['v_locales'] = $model->cargarLocales();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_dte'] = $model->listTipoDte();
        $data['v_unidad_medida'] = $model->listUnidadMedida();

        //$Compra = $model->getCompraMasivaAbierta(7);
        //$obj = json_decode($Compra);
        //if(Count($obj) > 0) $data['IdCompra'] = $obj[0]->IdCompra;

        if( isset($datos['IdCompra']) ){
            $data['IdCompra'] = $datos['IdCompra'];

        }else{

            $data['IdCompra'] = 0;

        }



        return View::make('compras.compraMasivaNew',$data);
    }

    protected function getCompraPurchaseList(){
        $model= new Compra();       
        $data['v_compras_listado_compra'] = $model->listComprasListadoCompra();
        
        return View::make('compras.compraPurchaseList',$data);
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
	
    //Registrar Detalle Compra Masiva
    protected function postRegistrarDetalleCompraMasiva(Request $request){
        $model= new Compra();
        
        $datos = $request->all();
        $IdCompra = $datos['IdCompra'];
        $datos['IdLocal'] = 7;
        
        if($IdCompra==null){
            $result['f_registro_compra'] = $model->regCompraMasiva($datos);
            log::info("Registro Compra: " . $result['f_registro_compra']);
            
            $obj = json_decode($result['f_registro_compra']);
            log::info($obj->IdCompra);
            
            $datos['IdCompra'] = $obj->IdCompra;
            $IdCompra =$obj->IdCompra;
            
        }else{
            $result['f_registro_compra'] = $model->getCabeceraCompraFirst($IdCompra);
            
        }
        
        $result['detalle_compra'] = $model->regDetalleCompraMasiva($datos);
        $result['v_detalle_compra_masiva'] = $model->getDetallesCompraMasiva($IdCompra);
        return $result;
    }

    //Registrar Detalle Compra Masiva
    protected function postCargarDetalleCompraMasiva(Request $request){
        log::info("postCargarDetalleCompraMasiva()");
        $model= new Compra();
        
        $datos = $request->all();
        $IdCompra = $datos['IdCompra'];
        
        log::info("IdCompra: ". $IdCompra);

        $result['v_detalle_compra_masiva'] = $model->getDetallesCompraMasiva($IdCompra);
        $result['v_resumen_compra_bodega'] = $model->rerporteCompraBodega($IdCompra);
        $result['v_resumen_compra_local'] = $model->rerporteCompraLocal($IdCompra);


        return $result;
    }
	

	//Registrar Bodega de Destino Detalle Compra Masiva
    protected function postRegistrarBodegaDestino(Request $request){
        $model= new Compra();
		
		$datos = $request->all();
		$IdCompraDetalle = $datos['IdDetalleCompraBD'];
		$IdCompra = $datos['IdCompraBD'];
		$IdProducto = $datos['IdProductoBD'];
		$datos['IdLocal'] = 7;
		
        log::info("IdCompraDetalle: " . $IdCompraDetalle);
        log::info("IdProducto: " . $IdProducto);


		if($IdCompraDetalle!=null){
			$result['f_registro_bodega_destino'] = $model->regCompraMasivaBodegaDestino($datos);
			log::info("Registro Bodega Destino: " . $result['f_registro_bodega_destino']);			
		}
		
        $result['v_bodega_destino'] = $model->getBodegasDestinoCompraMasiva($IdCompraDetalle);
		$result['v_detalle_compra_masiva'] = $model->getDetallesCompraMasiva($IdCompra);
        return $result;
    }
	
    //Registrar Bodega de Destino Detalle Compra Masiva
    protected function getBodegaDestino(Request $request){
        $model= new Compra();
		
		$datos = $request->all();
		$IdCompraDetalle = $datos['IdDetalleCompraBD'];
		log::info("IdCompraDetalle: ". $IdCompraDetalle);
		
        $detalle = $model->getOneCompraDetalle($IdCompraDetalle);
        $obj = json_decode($detalle);
        log::info("IdProducto: " . $obj[0]->IdProducto);

        $result['v_detalle_compra'] = $detalle = $model->getOneCompraDetalle($IdCompraDetalle);
        $result['v_bodega_destino'] = $model->getBodegasDestinoCompraMasiva($IdCompraDetalle);
        return $result;
    }
	
	//Registrar Bodega de Destino Detalle Compra Masiva
    protected function getStockProducto(Request $request){
        $modelPRO = new Producto();
		
		$datos = $request->all();
		$IdProducto = $datos['IdProducto'];
		log::info("IdProducto: ". $IdProducto);
		
        $result['v_stock'] = $modelPRO->listStock($IdProducto);
        return $result;
    }
	
	protected function postEliminarAsignacionBodegaDestino(Request $request){
        $model= new Compra();
		
		$datos = $request->all();
		$IdBodegaDestino = $datos['IdBodegaDestino'];		
		$bodegaDestino = $model->getBodegasDestinoById($IdBodegaDestino);
		
		$IdCompraDetalle = $bodegaDestino[0]->IdDetalleCompra;
		$IdCompra = $bodegaDestino[0]->IdCompra;
		$IdProducto = $bodegaDestino[0]->IdProducto;
		$IdBodega =  $bodegaDestino[0]->IdBodega;
		$Cantidad =  $bodegaDestino[0]->Cantidad;
		
		log::info("IdBodegaDestino: ". $IdBodegaDestino);
		log::info("IdProducto: " . $bodegaDestino[0]->IdProducto );
		log::info("IdBodega: " . $bodegaDestino[0]->IdBodega );
		log::info("IdDetalleCompra: " . $bodegaDestino[0]->IdDetalleCompra );
		log::info("IdCompra: " . $bodegaDestino[0]->IdCompra );
		
		
        $result['e'] = $model->eliminarAsginacionBodegaDestino($bodegaDestino);
		
		$result['v_bodega_destino'] = $model->getBodegasDestinoCompraMasiva($IdCompraDetalle);
		$result['v_detalle_compra_masiva'] = $model->getDetallesCompraMasiva($IdCompra);
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
		
        $result['producto'] = Producto::where('CodigoBarra',$datos['CodigoBarra'])->first();
        if($result['producto'] != null){
			$model= new Compra(); 
			$result['impuesto'] = $model->buscarImpuestos($result['producto']->IdProducto);	
			
		}else{
			$result['producto'] = '{IdProducto:0}'; 
			
		}
		
        return $result;
    }
	
	protected function postBuscarProductoMasivo(Request $request){
        $datos = $request->all();
        $result['productos'] = Producto::where('NombreProducto', 'like', '%'. $datos['InfoProducto'] .'%')->orWhere('CodigoBarra', $datos['InfoProducto'])->get();
        if($result['productos'] == null) { $result['productos'] = '{"IdProducto":0}'; }
		
        return $result;
    }

    protected function postBuscarDetallec(Request $request){
        $datos = $request->all();
        $model= new Compra();
        $result = $model->getOneCompraDetalle($datos['IdDetalleCompra']);
        return $result;
    }
}
