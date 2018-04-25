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

    // Cargar combo de tipo de dte
    public function listTipoDte(){
        return DB::table('v_tipo_dte')->get();
    }

    // Cargar combo Unidad de medida
    public function listUnidadMedida(){
        return DB::table('v_unidadmedida_combo')->get();
    }
        

    // registrar compra
    public function regCompra($datos){
        $idAdmin = Auth::id();
        $datos['IdCompra']==null ? $Id=0 : $Id= $datos['IdCompra'];
        $datos['FechaDTE'] = $this->formatearFecha($datos['FechaDTE']);
        $datos['FechaVencimiento'] = $this->formatearFecha($datos['FechaVencimiento']);
        $datos['FechaPago'] = $this->formatearFecha($datos['FechaPago']);
        $sql="select f_registro_compra(".$Id.",".$datos['IdOrdenCompra'].",".$datos['IdProveedor'].",".$datos['idEmpresa'].",".$datos['IdBodega'].",".$datos['TipoDTE'].",'".$datos['FolioDTE']."','".$datos['FechaDTE']."','".$datos['FechaVencimiento']."','".$datos['FechaPago']."','".$datos['TotalNeto']."','".$datos['TotalDescuentos']."','".$datos['TotalImpuestos']."','".$datos['TotalCompra']."',".$datos['EstadoCompra'].",".$datos['IdLocal'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // registrar Detalle compra
    public function regDetalleCompra($datos){
        $idAdmin = Auth::id();
        $datos['IdDetalleCompra']==null ? $Id=0 : $Id= $datos['IdDetalleCompra'];
        $sql="select f_registro_detalle_compra(".$Id.",".$datos['IdCompra2'].",".$datos['IdProducto'].",".$datos['IdUnidadMedida'].",'".$datos['CantidadComprada']."','".$datos['ValorUnitario']."','".$datos['FactorImpuesto']."','".$datos['ValorImpuestos']."','".$datos['MontoDescuento']."','".$datos['ValorUnitarioFinal']."','".$datos['TotalLinea']."',".$datos['EstadoDetalleCompra'].",".$idAdmin.")";
        $execute=DB::select($sql);
		log::info($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// registrar compra
    public function regCompraMasiva($datos){
        $idAdmin = Auth::id();
        $datos['IdCompra']==null ? $IdCompra=0 : $IdCompra= $datos['IdCompra'];
        $sql="select f_registro_compra(".$IdCompra.",Null,Null,Null,Null,5,Null,Now(),Now(),Now(),0,0,0,0,1,".$datos['IdLocal'].",".$idAdmin.")";
		log::info($sql);
		
		$execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// registrar compra
    public function regCompraMasivaBodegaDestino($datos){
        $idAdmin = Auth::id();
        $datos['IdDetalleCompraBD']==null ? $IdDetalleCompraBD=0 : $IdDetalleCompraBD= $datos['IdDetalleCompraBD'];
        $sql="select f_registro_detalle_compra_bodega_destino(Null, ".$IdDetalleCompraBD.",".$datos['IdProductoBD'].",".$datos['IdBodega'].",'".$datos['CantidadAsignada']."',".$idAdmin.")";
		log::info($sql);
		
		$execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// registrar Detalle compra masiva
    public function regDetalleCompraMasiva($datos){
        $idAdmin = Auth::id();
        $datos['IdDetalleCompra']==null ? $IdDetalleCompra=0 : $IdDetalleCompra= $datos['IdDetalleCompra'];
		$datos['TotalLinea'] = $datos['CantidadProducto'] * $datos['PrecioCosto'];
		
        $sql="select f_registro_detalle_compra_masiva(".$IdDetalleCompra.",".$datos['IdCompra'].",".$datos['IdProducto'].",'".$datos['CantidadProducto']."','".$datos['PrecioCosto']."','".$datos['PrecioVenta']."','".$datos['TotalLinea']."',1,".$idAdmin.")";
        $execute=DB::select($sql);
		log::info($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar Compra
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

    public function getCabeceraCompra($IdCompra){
        return DB::table('v_compras')->where('IdCompra',$IdCompra)->get(); 
    }
	
	public function getCabeceraCompraFirst($IdCompra){
        return DB::table('v_compras')->where('IdCompra',$IdCompra)->first(); 
    }

    public function getDetallesCompra($IdCompra){
        return DB::table('v_compras_detalle')->where('IdCompra',$IdCompra)->get(); 
    }
	
	public function getDetallesCompraMasiva($IdCompra){
        return DB::table('v_compras_detalle_masiva')->where('IdCompra',$IdCompra)->get(); 
    }
	
	public function getBodegasDestinoCompraMasiva($IdCompraDetalleBD){
        return DB::table('v_compras_detalle_bodegas')->where('IdDetalleCompra',$IdCompraDetalleBD)->get(); 
    }
	
	public function getBodegasDestinoById($Id){
        return DB::table('v_compras_detalle_bodegas')->where('Id',$Id)->get(); 
    }

	public function eliminarAsginacionBodegaDestino($bodegaDestino){
        $idAdmin = Auth::id();
		
		$Id  = $bodegaDestino[0]->Id;
		$IdCompraDetalle = $bodegaDestino[0]->IdDetalleCompra;
		$IdCompra = $bodegaDestino[0]->IdCompra;
		$IdProducto = $bodegaDestino[0]->IdProducto;
		$IdBodega =  $bodegaDestino[0]->IdBodega;
		$Cantidad =  $bodegaDestino[0]->Cantidad;
		
		$sql="select f_registro_detalle_compra_bodega_destino(".$Id.", ".$IdCompraDetalle.",".$IdProducto.",".$IdBodega.",'-".$Cantidad."',".$idAdmin.")";
		log::info($sql);
		
		$execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }

    }
	
	public function asignarStock($IdProducto,$IdBodega,$Cantidad){
        $idAdmin = Auth::id();
		
        $values=array('Stock'=>Stock - $Cantidad);
        
        return DB::table('Stock')
                ->where([['IdProducto', $IdProducto],['IdBodega', $IdBodega]])
                ->update($values);

    }


    public function regProveedor($datos){
        $values=array('RUTProveedor' => $datos['RUTProveedor2'] , 'NombreFantasia' => $datos['NombreFantasia2']);
        $id = DB::table('proveedores')->insertGetId($values);
        return $id;
    }

    
    public function buscarLocales($IdEmpresa){
        return DB::table('v_locales_combo')->where('IdEmpresa',$IdEmpresa)->get();
    }
	
	public function cargarLocales(){
		log::info("cargarLocales()");

        return DB::table('v_locales_combo')->get();
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

    public function getOneCompraDetalle($IdDetalleCompra){
        return DB::table('v_compras_detalle')->where('IdDetalleCompra',$IdDetalleCompra)->get();
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