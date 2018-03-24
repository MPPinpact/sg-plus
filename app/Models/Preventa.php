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

class Preventa extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'preventas';

    protected $primaryKey = 'idPreVenta';

    protected $fillable = [
        'IdVenta','IdVendedor','IdLocal','IdCaja','FechaPreVenta','TotalNeto','TotalDescuentos','TotalImpuestos','TotalPreVenta','ComentarioPreVenta','EstadoPreVenta','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de impuesto
    public function listPreventas(){
        return DB::table('v_preventas')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }
    
    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listBodega(){
        return DB::table('v_bodegas_combo')->get();
    }

    // Cargar combo de tipo de dte
    public function listTipoDte(){
        return DB::table('v_tipo_dte')->get();
    }

    // Cargar combo Unidad de medida
    public function listUnidadMedida(){
        return DB::table('v_unidadmedida_combo')->get();
    }
        

    // registrar compra
    public function regPreventa($datos){
        $idAdmin = Auth::id();
        $datos['idPreVenta']==null ? $Id=0 : $Id= $datos['idPreVenta'];
        $datos['FechaPreVenta'] = $this->formatearFecha($datos['FechaPreVenta']);
        $sql="select f_registro_preventa(".$Id.",".$datos['IdCliente'].",".$datos['IdVendedor'].",".$datos['IdLocal'].",".$datos['IdCaja'].",'".$datos['FechaPreVenta']."',".$idAdmin.")";
	$execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }


    // registrar Detalle compra
    public function regDetallePreventa($datos){
        $idAdmin = Auth::id();
        $datos['IdDetallePreVenta']==null ? $Id=0 : $Id= $datos['IdDetallePreVenta'];
        $sql="select f_registro_detalle_preventa(".$Id.",".$datos['IdPreVenta2'].",".$datos['IdProducto'].",".$datos['IdUnidadMedida'].",'".$datos['CantidadPreVenta']."','".$datos['ValorUnitarioVenta']."','".$datos['FactorImpuesto']."','".$datos['ValorImpuestos']."','".$datos['MontoDescuento']."','".$datos['ValorUnitarioFinal']."','".$datos['TotalLinea']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar Compra
    public function activarPreventa($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoPreVenta']>0){
            $values=array('EstadoPreVenta'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoPreVenta'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('preventas')
                ->where('idPreVenta', $datos['idPreVenta'])
                ->update($values);
    }

    // Activar / Desactivar Detalle compra
    public function activarCompraDetalle($datos){
        $idAdmin = Auth::id();
        if ($datos[0]->EstadoDetalleCompra>0){
            $values=array('EstadoDetalleCompra'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoDetalleCompra'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('compras_detalle')
                ->where('IdDetalleCompra', $datos[0]->IdDetalleCompra)
                ->update($values);
    }

    public function getCabeceraPreventa($idPreVenta){
        return DB::table('v_preventas')->where('idPreVenta',$idPreVenta)->get(); 
    }

    public function getDetallesPreventa($idPreVenta){
        return DB::table('v_preventas_detalle')->where('idPreVenta',$idPreVenta)->get(); 
    }


    public function regProveedor($datos){
        $values=array('RUTProveedor' => $datos['RUTProveedor2'] , 'NombreFantasia' => $datos['NombreFantasia2']);
        $id = DB::table('proveedores')->insertGetId($values);
        return $id;
    }

    
    public function buscarLocales($IdEmpresa){
        return DB::table('v_locales_combo')->where('IdEmpresa',$IdEmpresa)->get();
    }

    
    public function getBodegas($IdLocal){
        return DB::table('v_bodegas_combo')->where('IdLocal',$IdLocal)->get();
    }

    public function formatearFecha($d){
        $formato = explode("-", $d);
        $fecha = $formato[2]."-".$formato[1]."-".$formato[0];
        return $fecha;
    }

    public function buscarCombos($datos){
        $result['v_local'] = DB::table('v_locales_combo')->where('id',$datos['IdLocal'])->get();
        $result['v_bodega'] = DB::table('v_bodegas_combo')->where('id',$datos['IdBodega'])->get();
        return $result;
    }

    public function getOnePreventaDetalle($IdDetallePreVenta){
        log::info("detalle preventa");
        return DB::table('v_preventas_detalle')->where('IdDetallePreVenta',$IdDetallePreVenta)->get();
    }

    public function buscarImpuestos($IdProducto){
        $impuestos = DB::table('v_productos_impuestos')->where('IdProducto',$IdProducto)->get();
        $factorImpuesto = 0;
        // ValorImpuesto
        foreach ($impuestos as $key => $value) {
            foreach ($value as $llave => $valor) {
                if ($llave == 'ValorImpuesto'){ 
                    $factorImpuesto += $valor; 
                }    
            }
        }
        $factorImpuesto = ($factorImpuesto / 100);
        return $factorImpuesto;
    }

    

}
