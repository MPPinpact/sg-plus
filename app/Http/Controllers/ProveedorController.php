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

use App\Models\Proveedor;

class ProveedorController extends Controller
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

    public function getProveedor()
    {
        $model= new Proveedor();
        $data['v_proveedores'] = $model->listProveedor();
        // $data['v_locales'] = $model->listLocales();
        $data['v_estados'] = $model->listEstados();
        return View::make('proveedores.proveedores',$data);
    }

    //Registrar o actualizar proveedor
    protected function postProveedor(Request $request){
        $datos = $request->all();
        $model= new Proveedor();
        $result['f_registro'] = $model->regProveedor($datos);
        $result['v_bodegas'] = $model->listProveedor();
        return $result;
    }

    //Activar / desactivar proveedor
    protected function postProveedoractivo (Request $request){
        $datos = $request->all();
        $model= new Proveedor();
        $proveedor = Proveedor::find($datos['IdProveedor']);
        $result['activar'] = $model->activarProveedor($proveedor);
        $result['v_proveedores'] = $model->listProveedor();
        return $result;
    }

    // Ver detalles de los proveedor
    protected function postProveedordetalle (Request $request){
        $datos = $request->all();
        $model= new Proveedor();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdProveedor']);
        // $result['v_productos'] = $model->localesProducto($datos['IdProveedor']);
        return $result;
    }

}
