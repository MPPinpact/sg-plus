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
        return DB::table('v_preventas')->where('EstadoPreVenta', '<>', 0)->get();
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
        $datos['IdCliente']==null ? $datos['IdCliente']=0 : $datos['IdCliente']= $datos['IdCliente'];
        $datos['FechaPreVenta'] = $this->formatearFecha($datos['FechaPreVenta']);
        $sql="select f_registro_preventa(".$Id.",".$datos['IdCliente'].",".$datos['IdVendedor'].",".$datos['IdLocal'].",".$datos['IdCaja'].",'".$datos['FechaPreVenta']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// Registrar Pre-Venta desde el Módulo Punto de Venta
    public function regPreVentaPuntoVenta($datos){
        $IdUsuario = Auth::id();
		
        $datos['IdPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['IdPreVenta'];		
		$datos['IdClientePreVenta']==null ? $datos['IdClientePreVenta']="null" :$datos['IdClientePreVenta']=$datos['IdClientePreVenta'];
		$datos['IdVendedorPreVenta']==null ? $datos['IdVendedorPreVenta']="null" :$datos['IdVendedorPreVenta']=$datos['IdVendedorPreVenta'];
		$datos['IdLocalPreVenta']==null ? $datos['IdLocalPreVenta']="null" :$datos['IdLocalPreVenta']=$datos['IdLocalPreVenta'];
		$datos['IdCajaPreVenta']==null ? $datos['IdCajaPreVenta']="null" :$datos['IdCajaPreVenta']=$datos['IdCajaPreVenta'];
		
		$sql="select f_registro_preventa(".$IdPreVenta.",".$datos['IdClientePreVenta'].",".$datos['IdVendedorPreVenta'].",".$datos['IdLocalPreVenta'].",".$datos['IdCajaPreVenta'].",'".$datos['FechaPreVenta']."',".$IdUsuario.")";

        log::info($sql);
        $execute=DB::select($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	public function regVendedorPreVenta($datos){
		$IdUsuario = Auth::id();
		 
		$datos['IdPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['IdPreVenta'];		
		$datos['IdVendedorPreVenta']==null ? $datos['IdVendedorPreVenta']="null" :$datos['IdVendedorPreVenta']=$datos['IdVendedorPreVenta'];
		
		$sql="select f_actualizar_preventa_vendedor(".$IdPreVenta.",".$datos['IdVendedorPreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
		//log::info($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
	}
	
	public function regClientePreVenta($datos){
        $IdUsuario = Auth::id();
         
        $datos['IdPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['IdPreVenta'];     
        $datos['IdClientePreVenta']==null ? $datos['IdClientePreVenta']="null" :$datos['IdClientePreVenta']=$datos['IdClientePreVenta'];
        
        $sql="select f_actualizar_preventa_cliente(".$IdPreVenta.",".$datos['IdClientePreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
        //log::info($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    public function regTipoDTEPreVenta($datos){
        $IdUsuario = Auth::id();
         
        $datos['IdPreVenta']==null ? $IdPreVenta=0 : $IdPreVenta= $datos['IdPreVenta'];     
        $datos['IdTipoDTEPreVenta']==null ? $datos['IdTipoDTEPreVenta']="null" :$datos['IdTipoDTEPreVenta']=$datos['IdTipoDTEPreVenta'];
        
        $sql="select f_actualizar_preventa_tipodte(".$IdPreVenta.",".$datos['IdTipoDTEPreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
        //log::info($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// Registrar Detalle Pre-Venta desde el Módulo Punto de Venta
    public function regDetallePreVentaPuntoVenta($datos){
        $IdUsuario = Auth::id();
		
        $datos['IdDetallePreVenta']==null ? $Id=0 : $Id= $datos['IdDetallePreVenta'];
		
        $sql="select f_registro_detalle_preventa(".$Id.",".$datos['IdPreVenta'].",".$datos['IdProductoPreVenta'].",null,'".$datos['CantidadProductoPreVenta']."','".$datos['PrecioProductoPreVenta']."','0','0','0','0','".$datos['TotalLineaPreVenta']."',".$IdUsuario.")";

//log::info($sql);

        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

	// Registrar Pago Pre-Venta
    public function regPagoPreVenta($datos){
        $idAdmin = Auth::id();
		
		//log::info("IdPreVenta: " . $datos['IdPreVentaPago']);
		
        $datos['IdDetallePago']==null ? $Id=0 : $Id= $datos['IdDetallePago'];
		
		$fpc = $datos['FechaPrimeraCuota']; 
		if($fpc == "") $fpc = date("d-m-Y");
		else $fpc = $this->formatearFecha($fpc);
		
        $sql="select f_registro_pago_preventas(".$Id.",".$datos['IdPreVentaPago'].",".$datos['IdFormaPagoPreVenta'].",'".$datos['CodigoAprobacionTarjeta']."','".$datos['NumeroTransaccionTarjeta']."','".$datos['IdClienteVC']."', '".$fpc."','".$datos['NumeroCuotasCredito']."','".$datos['InteresMensualCredito']."','".$datos['MontoFinalCredito']."','".$datos['MontoCuotaCredito']."','".$datos['MontoPagoEfectivo']."',1,".$idAdmin.")";
		//log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	public function getDetallePago($IdPreVenta){
        return DB::table('v_preventas_pagos')->where('IdPreVenta', $IdPreVenta)->get(); 
    }
	
	public function getOnePagoPreVenta($IdDetallePago){
        return DB::table('v_preventas_pagos')->where('IdDetallePago',$IdDetallePago)->first();
    }
	
	public function activarDetallePago($IdDetallePago){
		$IdAdmin = Auth::id();
		$values=array('EstadoPago'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$IdAdmin);
		return DB::table('preventas_pagos')->where('IdDetallePago', $IdDetallePago)->update($values);
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
        if ($datos['EstadoPreVenta']==1){
            $values=array('EstadoPreVenta'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos['EstadoPreVenta']==0){
            $values=array('EstadoPreVenta'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos['EstadoPreVenta']>1){
            return 204;
        }
        return DB::table('preventas')
                ->where('idPreVenta', $datos['idPreVenta'])
                ->update($values);
    }

    // Activar / Desactivar Detalle preventa
    public function activarPreVentaDetalle($datos){
        $idAdmin = Auth::id();
        if ($datos[0]->EstadoPreVentaDetalle > 0){
            $values=array('EstadoPreVentaDetalle'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoPreVentaDetalle'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('preventas_detalle')
                ->where('IdDetallePreVenta', $datos[0]->IdDetallePreVenta)
                ->update($values);
    }

    public function getPreventa($idPreVenta, $idLocal){
        return DB::table('v_preventas')->select(DB::raw('COUNT(1) AS PreVenta'))->where('idPreVenta',$idPreVenta)->where('IdLocal', $idLocal)->first(); 
    }

    public function getCabeceraPreventa($idPreVenta){
        return DB::table('v_preventas')->where('idPreVenta',$idPreVenta)->get(); 
    }

    public function getDetallesPreventa($idPreVenta){
        return DB::table('v_preventas_detalle')->where('idPreVenta',$idPreVenta)->where('EstadoPreVentaDetalle',1)->get(); 
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
        return DB::table('v_preventas_detalle')->where('IdDetallePreVenta',$IdDetallePreVenta)->get();
    }

    public function buscarImpuestos($IdProducto){
        $impuestos = DB::table('v_productos_impuestos')->where('IdProducto',$IdProducto)->get();
        $factorImpuesto = 0;
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

    public function cerrarPreventa($IdPreventa){
        $idAdmin = Auth::id();
		
        $values=array('EstadoPreVenta'=>2,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        
		return DB::table('preventas')
                ->where('idPreVenta', $IdPreventa)
                ->update($values);
    }

    

}
