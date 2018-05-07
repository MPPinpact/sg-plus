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

use App\Models\Cliente;
use App\Models\Usuario;

class ClienteController extends Controller
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

    public function getCliente()
    {
        $model= new Cliente();
        $data['v_clientes'] = $model->listClientes();
        $data['v_estados'] = $model->listEstados();
        $data['v_ciclos'] = $model->listCiclos();
        return View::make('clientes.clientes',$data);
    }

    //Registrar o actualizar cliente
    protected function postCliente(Request $request){
        $datos = $request->all();
        $model= new Cliente();
        $result['f_registro'] = $model->regCliente($datos);
        $result['v_clientes'] = $model->listClientes();
        return $result;
    }

    //Activar / desactivar cliente
    protected function postClienteactivo (Request $request){
        $datos = $request->all();
        $model= new Cliente();
        $cliente = Cliente::find($datos['IdCliente']);
        $result['activar'] = $model->activarCliente($cliente);
        $result['v_clientes'] = $model->listClientes();
        return $result;
    }

    // Ver detalles de los cliente
    protected function postClientedetalle (Request $request){
        $datos = $request->all();
        $model= new Cliente();
        $result['v_detalles'] = $model->getDetallesClientes($datos['IdCliente']);
        $result['v_movimientos'] = $model->listMovimientos($datos['IdCliente']);
        $result['v_movimientos_ultimo_eecc'] = $model->listMovimientosUltimoEECC($datos['IdCliente']);
        $result['v_movimientos_proximo_eecc'] = $model->listMovimientosProximoEECC($datos['IdCliente']);
        $result['v_eecc'] = $model->listeecc($datos['IdCliente']);
        return $result;
    }
}
