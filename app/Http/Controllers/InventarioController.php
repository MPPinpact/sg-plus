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

use App\Models\Inventario;
use App\Models\Usuario;

class InventarioController extends Controller
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

    public function getInventario()
    {
        $model= new Inventario();
        $data['v_inventario'] = $model->listInventario();
        $data['v_estados'] = $model->listEstados();
        $data['v_tipo_inventario'] = $model->listTipoInventario();
        return View::make('inventario.inventario',$data);
    }

    //Registrar o actualizar bodega
    protected function postInventario(Request $request){
        $datos = $request->all();
        $user= new Usuario();
        $model= new Inventario();
        $result['f_registro'] = $model->regInventario($datos);
        $result['v_inventario'] = $model->listInventario();
        return $result;
    }

    //Activar / desactivar bodega
    // protected function postBodegactivo (Request $request){
    //     $datos = $request->all();
    //     $model= new Inventario();
    //     $bodega = Bodega::find($datos['IdBodega']);
    //     $result['activar'] = $model->activarBodega($bodega);
    //     $result['v_bodegas'] = $model->listBodega();
    //     return $result;
    // }

    // Ver detalles de los bodegas
    // protected function postBodegadetalle (Request $request){
    //     $datos = $request->all();
    //     $model= new Inventario();
    //     $result['v_detalles'] = $model->getOneDetalle($datos['IdBodega']);
    //     $result['v_productos'] = $model->listProductos($datos['IdBodega']);
    //     return $result;
    // }

}
