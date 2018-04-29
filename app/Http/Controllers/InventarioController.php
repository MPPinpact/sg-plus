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
        $data['v_tipo_inventario'] = $model->listTipoInventario();
        $data['v_bodegas'] = $model->listBodega();
        return View::make('inventario.inventario',$data);
    }

    //Registrar o actualizar bodega
    protected function postInventario(Request $request){
        $datos = $request->all();
        $user= new Usuario();
        $model= new Inventario();
        $result['f_registro'] = $model->regInventario($datos);
        $result['v_inventario'] = $model->listInventario();
        $result['IdBodega'] = $datos['IdBodega'];
        return $result;
    }

    //Activar / desactivar bodega
    protected function postInventarioactivo (Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $inventario = Inventario::find($datos['IdInventario']);
        $result = $model->activarInventario($inventario);
        return $result;
    }

    protected function postCerrarInventario(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $inventario = Inventario::find($datos['IdInventario']);
        $result = [];
        if ($datos['caso']==1){
            $result = $model->getCerrarInventario($inventario);
        }
        if ($datos['caso']==2){
            $result = $model->getAjustarInventario($inventario);
        }
        return $result;       
    }

    protected function postBuscarInventario(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result['v_familias'] = $model->getBuscarFamiliasCombo($datos['IdInventario']);
        $result['v_cabecera'] = $model->getCabeceraInventario($datos['IdInventario']);
        $result['v_detalles'] = $model->getDetallesInventario($datos['IdInventario']);
        return $result;
    }

    // Ver detalles de los bodegas
    protected function postBuscarDetalleInventario (Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result = $model->getOneDetalle($datos['IdInventarioDetalle']);
        return $result;
    }

    protected function postRegistrarDetalleInventario(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result['f_registro'] = $model->regDetalleInventario($datos);
        $result['v_detalles'] = $model->getDetallesInventario($datos['IdInventario2']);        
        return $result;
    }

    protected function postbuscarProducto(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result = $model->getBusquedaProducto($datos);
        return $result;      
    }

    protected function postbuscarBodega(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result = $model->getBuscarBodega($datos['IdBodega']);
        return $result;        
    }

    protected function postbuscarFamilia(Request $request){
        $datos = $request->all();
        $model= new Inventario();
        $result = $model->getBuscarFamilias($datos);
        return $result;      
    }





}