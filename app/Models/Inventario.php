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

class Inventario extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'inventario';

    protected $primaryKey = 'IdInventario';

    protected $fillable = [
		'Comentario','TipoInventario','EstadoInventario','IdBodega','auUsuarioModificacion','auUsuarioCreacion',
    ];

    protected $dates = [
		'FechaInventario','FechaTomaInventario','FechaAjusteInventario','auFechaModificacion','auFechaCreacion'
    ];



    // Cargar tabla de bodega
    public function listInventario(){
        return DB::table('v_bodegas')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados_inventario')->get();
    }

    // Cargar combo de Locales
    public function listTipoInventario(){
        return DB::table('v_tipo_inventario')->get();
    }

    // registrar una nueva bodega
    public function regInventario($datos){
        $idAdmin = Auth::id();
        $datos['IdBodega']==null ? $Id=0 : $Id= $datos['IdBodega'];
        $sql="select f_registro_bodega(".$Id.",'".$datos['NombreBodega']."','".$datos['DescripcionBodega']."',".$datos['IdLocal'].",".$datos['EstadoBodega'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_bodega']=$value;
        }
        return $result;
    }

    // Activar / Desactivar bodega
    // public function activarBodega($datos){
    //     $idAdmin = Auth::id();
    //     if ($datos['EstadoBodega']>0){
    //         $values=array('EstadoBodega'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
    //     }else{
    //         $values=array('EstadoBodega'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
    //     }
    //     return DB::table('bodegas')
    //             ->where('IdBodega', $datos['IdBodega'])
    //             ->update($values);
    // }

    // public function listProductos($IdBodega){   
    //     $result['productos'] =  DB::table('v_bodegas_productos')->where('IdBodega',$IdBodega)->get(); 
    //     $sql="select SUM(MontoValorizado) as TotalValorizado from v_bodegas_productos where IdBodega=".$IdBodega;
    //     $result['sum']=DB::select($sql);
    //     return $result;
    // }

    public function getOneDetalle($IdBodega){
        return DB::table('v_bodegas')->where('IdBodega',$IdBodega)->get(); 
    }  

}