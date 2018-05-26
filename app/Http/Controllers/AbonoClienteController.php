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

use App\Models\AbonoCliente;
use App\Models\Cliente;
use App\Models\Usuario;

class AbonoClienteController extends Controller
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

    public function getAbonoCliente()
    {
        $model= new AbonoCliente();
        $data['v_abono_cliente'] = $model->listAbonoCliente();
        $data['v_formas_pago'] = $model->listFormaPago();
        return View::make('AbonoCliente.AbonoCliente',$data);
    }

    //Registrar o actualizar proveedor
    protected function postAbonoCliente(Request $request){
        log::info("Hooooooola 22222");
        $datos = $request->all();
        $model= new AbonoCliente ();
        $result['f_registro'] = $model->regAbonoCliente($datos);
        $result['v_abono_cliente'] = $model->listAbonoCliente();
        return $result;
    }

    //Activar / desactivar proveedor
    protected function postAbonoClienteactivo (Request $request){        
        $datos = $request->all();
        $model= new AbonoCliente();
        $proveedor = AbonoCliente::find($datos['IdAbono']);
        $result['activar'] = $model->activarAbonoCliente($proveedor);
        $result['v_abono_cliente'] = $model->listAbonoCliente();
        return $result;
    }

    // Ver detalles de los proveedor
    protected function postAbonoClientedetalle (Request $request){
        $datos = $request->all();
        $model= new AbonoCliente();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdAbono']);
        // $result['v_productos'] = $model->localesProducto($datos['IdProveedor']);
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

}







