<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\QueryException;
use App\Exceptions\Handler;
use Illuminate\Mail\Mailable;

use DB;
use Log;
use DateTime;
use Session;
use Exception;
use Auth;

class Producto extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'productos';

    protected $primaryKey = 'IdProducto';

    protected $fillable = [
        'CodigoBarra','CodigoProveedor','NombreProducto','DescripcionProducto','IdUltimoProveedor','IdFamilia','IdSubFamilia','IdUnidadMedida','SeCompra','SeVende','EsProductoCombo','Descontinuado','StockMinimo','StockMaximo','StockRecomendado','PrecioUltimaCompra','PrecioVentaSugerido','IdBodega','auUsuarioModificacion','auUsuarioCreacion','EstadoProducto'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listProductos(){
        return DB::table('v_productos')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // Cargar combo Familia
    public function listFamilias(){
        return DB::table('v_familias_combo')->get();
    }

    // Cargar combo SubFamilia
    public function listSubfamilias(){
        return DB::table('v_subfamilias_combo')->get();
    }

    // Cargar combo Unidad de medida
    public function listUnidadmedidas(){
        return DB::table('v_unidadmedida_combo')->get();
    }

    // Cargar combo de Bodega
    public function listBodegas(){
        return DB::table('v_bodegas_combo')->get();
    }

    // registrar una nueva producto
    public function regBodega($datos){
        log::info($datos);
        $idAdmin = Auth::id();
        $datos['IdProducto']==null ? $Id=0 : $Id= $datos['IdProducto'];
        $sql="select f_registro_producto(".$Id.",'".$datos['CodigoBarra']."','".$datos['CodigoProveedor']."','".$datos['NombreProducto']."','".$datos['DescripcionProducto']."',".$datos['IdUltimoProveedor'].",".$datos['IdFamilia'].",".$datos['IdSubFamilia'].",".$datos['IdUnidadMedida'].",".$datos['SeCompra'].",".$datos['SeVende'].",".$datos['EsProductoCombo'].",".$datos['Descontinuado'].",".$datos['StockMinimo'].",".$datos['StockMaximo'].",".$datos['StockRecomendado'].",'".$datos['PrecioUltimaCompra']."','".$datos['PrecioVentaSugerido']."',".$datos['IdBodega'].",".$datos['EstadoProducto'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_producto']=$value;
        }
        return $result;
    }

    // Activar / Desactivar producto
    public function activarProducto($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoProducto']>0){
            $values=array('EstadoProducto'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoProducto'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('productos')
                ->where('IdProducto', $datos['IdProducto'])
                ->update($values);
    }

    public function descontinuarProducto($datos){
        $idAdmin = Auth::id();
        if ($datos['Descontinuado']>1){
            $values=array('Descontinuado'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('Descontinuado'=>2,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('productos')
                ->where('IdProducto', $datos['IdProducto'])
                ->update($values);
    }

    // public function localesProducto($IdBodega){    
    //     return DB::table('v_productos')->where('IdBodega',$IdBodega)->get(); 
    // }

    public function getOneDetalle($IdBodega){
        return DB::table('v_bodegas')->where('IdBodega',$IdBodega)->get(); 
    }  

}