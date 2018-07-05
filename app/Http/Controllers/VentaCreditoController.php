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

use App\Models\VentaCredito;
use App\Models\Cliente;
use App\Models\Usuario;

class VentaCreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getVentaCredito()
    {
        $model= new VentaCredito();
        $data['v_credito_venta'] = $model->listVentaCredito();
        $data['v_estados'] = $model->listEstados();
        $data['v_clientes'] = $model->listClientesCombo();
        $data['v_prefencias'] = $model->listPrefenciActiva();
        return View::make('ventaCredito.ventaCredito',$data);
    }

    //Registrar o actualizar producto
    protected function postVentaCredito(Request $request){
        $datos = $request->all();
        $model= new VentaCredito();
        $result['f_registro'] = $model->regVentaCredito($datos);
        $result['v_credito_venta'] = $model->listVentaCredito();
        return $result;
    }

    //Activar / desactivar producto
    protected function postVentaCreditoactivo (Request $request){
        $datos = $request->all();
        $model= new VentaCredito();
        $bodega = VentaCredito::find($datos['IdVentaCredito']);
        $result['activar'] = $model->activarVentaCredito($bodega);
        $result['v_credito_venta'] = $model->listVentaCredito();
        return $result;
    }

    protected function postBuscarVentaCredito (Request $request){
        $datos = $request->all();
        $model= new VentaCredito();
        // $result ['v_detalles'] = VentaCredito::find($datos['IdVentaCredito']);
        $result ['v_detalles'] = $model->getDetallesVentaCredito($datos['IdVentaCredito']);
        return $result;
    }

    protected function postBuscarCliente (Request $request){
        //log::info("Cargar cliente Venta Credito");
		
		$datos = $request->all();
        $usuario= new Usuario();

        $datos['RUTCliente'] = $usuario->LimpiarRut($datos['RUTCliente']);
        log::info("RUT CLiente: " . $datos['RUTCliente']);

        $venta= new VentaCredito();
        $result['v_cliente'] = $venta->getOneCliente($datos['RUTCliente']);

        if(count($result['v_cliente'])){
            $result['v_fechas'] = $venta->calcularFechaPago($result['v_cliente']);    
        }else{
            $result['v_fechas'] = $venta->formatearFecha(date("Y-m-d"));
        }
        
        return $result;
    }

}
