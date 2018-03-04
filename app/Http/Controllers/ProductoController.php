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

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Proveedor;

class ProductoController extends Controller
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

    public function getProducto()
    {
        $model= new Producto();
        $data['v_productos'] = $model->listProductos();
        $data['v_estados'] = $model->listEstados();
        $data['v_impuestos'] = $model->listImpuestos();
        $data['v_familias'] = $model->listFamilias();
        $data['v_subfamilias'] = $model->listSubfamilias();
        $data['v_unidad'] = $model->listUnidadmedidas();
        $data['v_bodegas'] = $model->listBodegas();
        return View::make('productos.productos',$data);
    }

    //Registrar o actualizar producto
    protected function postProducto(Request $request){
        $datos = $request->all();
        $model= new Producto();
        $result['f_registro'] = $model->regProducto($datos);
        $result['v_productos'] = $model->listProductos();
        return $result;
    }

    //Activar / desactivar producto
    protected function postProductoactivo (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $bodega = Producto::find($datos['IdProducto']);
        $result['activar'] = $model->activarProducto($bodega);
        $result['v_productos'] = $model->listProductos();
        return $result;
    }

    // Descontiniar producto
    protected function postProductodescontinuar (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $producto = Producto::find($datos['IdProducto']);
        $result['descontinuar'] = $model->descontinuarProducto($producto);
        $result['v_productos'] = $model->listProductos();
        return $result;
    }

    // Ver detalles de los productos
    protected function postProductodetalle (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $result['v_detalles'] = $model->getProducto($datos['IdProducto']);
        $result['v_impuestos'] = $model->impuestosProducto($datos['IdProducto']);
        $result['v_productos'] = $model->localesProducto($datos['IdProducto']);
        return $result;
    }

    protected function postBuscarsub (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $result = $model->getSubfamilia($datos['IdFamilia']);
        return $result;
    }

    //asignar un nuevo impuesto
    protected function postprocesarImpuesto (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $result['f_registro_producto_impuesto'] = $model->regProductoImpuesto($datos);
        $result['v_impuestos'] = $model->impuestosProducto($datos['IdProducto2']);
        return $result;
    }

    //Activar / desactivar impuesto a producto
    protected function postImpuestopactivo (Request $request){
        $datos = $request->all();
        $model= new Producto();
        $impuesto = $model->getImpuesto($datos['IdProductoImpuesto']);
        $result['activar'] = $model->activarImpuestoProducto($impuesto);
        $result['v_impuestos'] = $model->impuestosProducto($impuesto[0]->IdProducto);
        return $result;
    }

    //Buscar el IDUltimoProveedor
    protected function postBuscarProveedor(Request $request){
        $datos = $request->all();
        $usuario= new Usuario();
        $datos['RUTProveedor'] = $usuario->LimpiarRut($datos['RUTProveedor']);
        $model= new Proveedor();
        $result ['v_proveedor'] = Proveedor::where('RUTProveedor', '=', $datos['RUTProveedor'])->first();
        return $result;
    }


}
