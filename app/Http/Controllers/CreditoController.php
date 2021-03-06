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

use App\Models\Credito;
use App\Models\Usuario;

class CreditoController extends Controller
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

    public function getCreditoPreferencias()
    {
        $model= new Credito();
        $data['v_credito_preferencias'] = $model->listPreferencias();
        $data['v_estados'] = $model->listEstados();
        return View::make('credito.credito',$data);
    }

    //Registrar o actualizar producto
    protected function postCreditoPreferencias(Request $request){
        $datos = $request->all();
        $model= new Credito();
        $result['f_registro'] = $model->regPreferencias($datos);
        $result['v_credito_preferencias'] = $model->listPreferencias();
        return $result;
    }

    //Activar / desactivar producto
    protected function postCreditoPreferenciaactivo (Request $request){
        $datos = $request->all();
        $model= new Credito();
        $credito = Credito::find($datos['IdCreditoPreferencia']);
        $result['activar'] = $model->activarCredito($credito);
        $result['v_credito_preferencias'] = $model->listPreferencias();
        return $result;
    }

    protected function postBuscarCreditoPreferencia (Request $request){
        $datos = $request->all();
        $model= new Credito();
        $result['v_detalles'] = $model->getPreferenciaCredito($datos['IdCreditoPreferencia']);
        return $result;
    }

    // Descontiniar producto
    // protected function postProductodescontinuar (Request $request){
    //     $datos = $request->all();
    //     $model= new Producto();
    //     $bodega = Producto::find($datos['IdProducto']);
    //     $result['descontinuar'] = $model->descontinuarProducto($bodega);
    //     $result['v_productos'] = $model->listProductos();
    //     return $result;
    // }

    // Ver detalles de los productos
    // protected function postProductodetalle (Request $request){
    //     $datos = $request->all();
    //     // $model= new Producto();
    //     // $result['v_detalles'] = $model->getOneDetalle($datos['IdProducto']);
    //     // $result['v_productos'] = $model->localesProducto($datos['IdProducto']);
    //     $result = '';
    //     return $result;
    // }

}
