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
        return DB::table('v_inventario')->where('EstadoInventario','<>',5)->get();
        // return DB::table('v_inventario')->get();
    }

    // Cargar combo de Locales
    public function listTipoInventario(){
        return DB::table('v_tipo_inventario')->get();
    }

    // Cargar combo de estados Bodegas
    public function listLocales(){
        return DB::table('v_locales_combo')->get();
    }

    // Cargar combo de estados Bodegas
    public function listBodega($IdLocal){
        return DB::table('v_bodegas_combo')->where('IdLocal',$IdLocal)->get();
    }

    // registrar una nueva bodega
    public function regInventario($datos){
        $idAdmin = Auth::id();
        $datos['IdInventario']==null ? $Id=0 : $Id= $datos['IdInventario'];
        $datos['FechaInventario'] = $this->formatearFecha($datos['FechaInventario']);
        $datos['FechaTomaInventario'] = $this->formatearFecha($datos['FechaTomaInventario']);
        $sql="select f_registro_inventario(".$Id.",'".$datos['FechaInventario']."','".$datos['FechaTomaInventario']."','".$datos['Comentario']."',".$datos['TipoInventario'].",".$datos['IdLocal'].",".$datos['IdBodega'].",".$idAdmin.")";
        log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    public function regDetalleInventario($datos){
        $idAdmin = Auth::id();
        $datos['IdInventarioDetalle']==null ? $Id=0 : $Id= $datos['IdInventarioDetalle'];
        $sql="select f_registro_inventario_detalle(".$Id.",".$datos['IdInventario2'].",".$datos['IdProducto'].",'".$datos['StockFisico']."','".$datos['StockSistema']."','0',0,".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    public function formatearFecha($d){
        $formato = explode("-", $d);
        $fecha = $formato[2]."-".$formato[1]."-".$formato[0];
        return $fecha;
    }

    // Activar / Desactivar bodega
    public function activarInventario($datos){
        $idAdmin = Auth::id();
        if ($datos->EstadoInventario == 5){
            $values=array('EstadoInventario'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos->EstadoInventario == 0){
            $values=array('EstadoInventario'=>5,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos->EstadoInventario > 0 && $datos->EstadoInventario < 5){
            $response['f_registro'] = '{"code": 204, "des_code": "No se puede eliminar un inventario que esta Cerrado o Finalizado"}';
            return $response;
        }
        DB::table('inventario')->where('IdInventario', $datos->IdInventario)->update($values);
        $response['f_registro'] = '{"code": 200, "des_code": "Actualización exitosa"}';
        $response['v_inventario'] = $this->listInventario();
        return $response;
    }


    public function getManejarInventario($datos){
        $idAdmin = Auth::id();
        $sql="select f_manejar_inventario(".$datos['Caso'].",".$datos['IdInventario'].",".$datos['IdBodega'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $response['f_registro']=$value;
        }
        $response['v_detalles'] = $this->getDetallesInventario($datos['IdInventario']);
        return $response;
    }

    public function getCabeceraInventario($IdInventario){
        return DB::table('v_inventario')->where('IdInventario',$IdInventario)->get(); 
    }

    public function getDetallesInventario($IdInventario){
        return DB::table('v_inventario_detalle')->where('IdInventario',$IdInventario)->get(); 
    }

    public function getOneDetalle($IdInventarioDetalle){
        return DB::table('v_inventario_detalle')->where('IdInventarioDetalle',$IdInventarioDetalle)->get(); 
    }

    public function getBusquedaProducto($datos){
        return DB::table('v_bodegas_productos')
            ->where('IdBodega',$datos['IdBodega'])
            ->where('CodigoBarra',$datos['CodigoBarra'])
            ->get(); 
    }

    public function getBuscarBodega($IdBodega){
        return DB::table('v_bodegas_productos')->where('IdBodega',$IdBodega)->get(); 
    }

    public function getBuscarFamiliasCombo($IdInventario){
        $sql="select IdFamilia AS id, NombreFamilia AS text from v_inventario_detalle where IdInventario =".$IdInventario." group by IdFamilia, NombreFamilia,IdInventario";
        return DB::select($sql);
    }

    public function getBuscarFamilias($datos){
        return DB::table('v_inventario_detalle')
            ->where('IdFamilia',$datos['IdFamilia'])
            ->where('IdBodega',$datos['IdBodega'])
            ->get(); 
    }


    

}