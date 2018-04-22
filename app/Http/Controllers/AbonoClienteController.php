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
// use App\Models\AbonoCliente;
// use App\Models\Proveedor;

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
        $data['v_formas_de_pago'] = $model->listFormasPago();
        return View::make('AbonoCliente.AbonoCliente',$data);
    }

    //Registrar o actualizar proveedor
    protected function postAbonoCliente(Request $request){
        $datos = $request->all();
        $model= new AbonoCliente ();
        $result['f_registro'] = $model->regAbonoCliente($datos);
        $result['v_formas_de_pago'] = $model->listFormasPago();
        return $result;
    }

    //Activar / desactivar proveedor
    protected function postAbonoClienteactivo (Request $request){        
        $datos = $request->all();
        $model= new AbonoCliente();
        $proveedor = AbonoCliente::find($datos['IdAbonoCliente']);
        $result['activar'] = $model->activarAbonoCliente($proveedor);
        $result['v_formas_de_pago'] = $model->listFormasPago();
        // var_dump($result);
        return $result;
    }

    // Ver detalles de los proveedor
    protected function postAbonoClientedetalle (Request $request){
        $datos = $request->all();
        $model= new AbonoCliente();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdAbonoCliente']);
        // $result['v_productos'] = $model->localesProducto($datos['IdProveedor']);
        return $result;
    }

}





