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

class Compra extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'compras';

    protected $primaryKey = 'IdCompra';

    protected $fillable = [
        'IdOrdenCompra','IdProveedor','IdBodega','RUTProveedor','TipoDTE','FolioDTE','FechaDTE','FechaVencimiento','FechaPago','TotalNeto','TotalDescuentos','TotalImpuestos','TotalCompra','auUsuarioModificacion','auUsuarioCreacion','EstadoCompra'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];



    // Cargar tabla de impuesto
    public function listCompra(){
        return DB::table('v_compras')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }
    
    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listBodega(){
        return DB::table('v_bodegas_combo')->get();
    }

    // registrar impuesto
    public function regCompra($datos){
        $idAdmin = Auth::id();
        $datos['IdCompra']==null ? $Id=0 : $Id= $datos['IdCompra'];
        $datos['FechaDTE'] = $this->formatearFecha($datos['FechaDTE']);
        $datos['FechaVencimiento'] = $this->formatearFecha($datos['FechaVencimiento']);
        $datos['FechaPago'] = $this->formatearFecha($datos['FechaPago']);
                 
        $sql="select f_registro_compra(".$Id.",".$datos['IdOrdenCompra'].",".$datos['IdProveedor'].",".$datos['IdBodega'].",".$datos['TipoDTE'].",'".$datos['FolioDTE']."','".$datos['FechaDTE']."','".$datos['FechaVencimiento']."','".$datos['FechaPago']."','".$datos['TotalNeto']."','".$datos['TotalDescuentos']."','".$datos['TotalImpuestos']."','".$datos['TotalCompra']."',".$datos['EstadoCompra'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar Impuesto
    public function activarCompra($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoCompra']>0){
            $values=array('EstadoCompra'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoCompra'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('compras')
                ->where('IdCompra', $datos['IdCompra'])
                ->update($values);
    }

    public function getCabeceraCompra($IdCompra){
        return DB::table('v_compras')->where('IdCompra',$IdCompra)->get(); 
    }

    public function getDetallesCompra($IdCompra){
        return DB::table('v_compras_detalle')->where('IdCompra',$IdCompra)->get(); 
    }

    public function formatearFecha($d){
        $formato = explode("-", $d);
        $fecha = $formato[2]."-".$formato[1]."-".$formato[0];
        return $fecha;
    }

}