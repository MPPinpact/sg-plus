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

class Venta extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'ventas';
    protected $primaryKey = 'IdVenta';

    protected $fillable = [
        'IdCredito','IdVendedor','IdLocal','IdCaja','FechaVenta','TotalNeto','TotalDescuentos','TotalImpuestos','TotalVenta','ComentarioVenta','EstadoVenta','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de impuesto
    public function listVentas(){
        return DB::table('v_ventas')->where('EstadoVenta', '<>', 0)->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados_ventas')->get();
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
	
    // registrar Venta
    public function regVenta($datos){
        $idAdmin = Auth::id();
        $datos['IdVenta']==null ? $Id=0 : $Id= $datos['IdVenta'];
        $datos['IdCliente']==null ? $datos['IdCliente']=0 : $datos['IdCliente']= $datos['IdCliente'];
        $datos['FechaVenta'] = $this->formatearFecha($datos['FechaVenta']);
        $sql="select f_registro_venta(".$Id.",".$datos['IdCliente'].",".$datos['IdVendedor'].",".$datos['IdLocal'].",".$datos['IdCaja'].",'".$datos['FechaVenta']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
    // registrar Detalle Venta
    public function regDetalleVenta($datos){
        $idAdmin = Auth::id();
        $datos['IdDetalleVenta']==null ? $Id=0 : $Id= $datos['IdDetalleVenta'];
        $sql="select f_registro_detalle_venta(".$Id.",".$datos['IdVenta2'].",".$datos['IdProducto'].",".$datos['IdUnidadMedida'].",'".$datos['CantidadVenta']."','".$datos['ValorUnitarioVenta']."','".$datos['FactorImpuesto']."','".$datos['ValorImpuestos']."','".$datos['MontoDescuento']."','".$datos['ValorUnitarioFinal']."','".$datos['TotalLinea']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

	// Registrar Pre-Venta desde el Módulo Punto de Venta
    public function regVentaPuntoVenta($datos){
        $IdUsuario = Auth::id();
		
        $datos['IdPreVenta']==null ? $IdVenta=0 : $IdVenta= $datos['IdPreVenta'];		
		$datos['IdClientePreVenta']==null ? $datos['IdClientePreVenta']="null" :$datos['IdClientePreVenta']=$datos['IdClientePreVenta'];
		$datos['IdVendedorPreVenta']==null ? $datos['IdVendedorPreVenta']="null" :$datos['IdVendedorPreVenta']=$datos['IdVendedorPreVenta'];
		$datos['IdLocalPreVenta']==null ? $datos['IdLocalPreVenta']="null" :$datos['IdLocalPreVenta']=$datos['IdLocalPreVenta'];
		$datos['IdCajaPreVenta']==null ? $datos['IdCajaPreVenta']="null" :$datos['IdCajaPreVenta']=$datos['IdCajaPreVenta'];
		
		$sql="select f_registro_venta(".$IdVenta.",".$datos['IdClientePreVenta'].",".$datos['IdVendedorPreVenta'].",".$datos['IdLocalPreVenta'].",".$datos['IdCajaPreVenta'].",'".$datos['FechaPreVenta']."',".$IdUsuario.")";

        log:info("regVentaPuntoVenta: " . $sql);

        $execute=DB::select($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// Registrar Detalle Venta desde el Módulo Punto de Venta
    public function regDetalleVentaPuntoVenta($datos){
        $IdUsuario = Auth::id();
		
        $datos['IdDetallePreVenta']==null ? $Id=0 : $Id= $datos['IdDetallePreVenta'];
        $sql="select f_registro_detalle_venta(".$Id.",".$datos['IdPreVenta'].",".$datos['IdProductoPreVenta'].",null,'".$datos['CantidadProductoPreVenta']."','".$datos['PrecioProductoPreVenta']."','0','0','0','0','".$datos['TotalLineaPreVenta']."',".$IdUsuario.")";
        log::info($sql);
        
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	public function regVendedorVenta($datos){
		$IdUsuario = Auth::id();
		 
		$datos['IdPreVenta']==null ? $IdVenta=0 : $IdVenta= $datos['IdPreVenta'];		
		$datos['IdVendedorPreVenta']==null ? $datos['IdVendedorPreVenta']="null" :$datos['IdVendedorPreVenta']=$datos['IdVendedorPreVenta'];
		
		$sql="select f_actualizar_venta_vendedor(".$IdVenta.",".$datos['IdVendedorPreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
		//log::info($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
	}
	
    public function regTipoDTEVenta($datos){
        $IdUsuario = Auth::id();
        
        isset($datos['IdVenta']) ? $IdVenta= $datos['IdVenta'] : $IdVenta=$datos['IdPreVenta'];
        
        $datos['IdPreVenta']==null ? $IdVenta=0 : $IdVenta= $datos['IdPreVenta'];     
        $datos['IdTipoDTEPreVenta']==null ? $datos['IdTipoDTEPreVenta']="null" :$datos['IdTipoDTEPreVenta']=$datos['IdTipoDTEPreVenta'];
        
        $sql="select f_actualizar_venta_tipodte(".$IdVenta.",".$datos['IdTipoDTEPreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
        //log::info($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

	public function regClienteVenta($datos){
		$IdUsuario = Auth::id();
		 
		$datos['IdPreVenta']==null ? $IdVenta=0 : $IdVenta= $datos['IdPreVenta'];		
		$datos['IdClientePreVenta']==null ? $datos['IdClientePreVenta']="null" :$datos['IdClientePreVenta']=$datos['IdClientePreVenta'];
		
		$sql="select f_actualizar_venta_cliente(".$IdVenta.",".$datos['IdClientePreVenta'].",".$IdUsuario.")";
        $execute=DB::select($sql);
		//log::info($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
	}
	
    // Activar / Desactivar Venta
    public function activarVenta($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoVenta']==1){
            $values=array('EstadoVenta'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos['EstadoVenta']==0){
            $values=array('EstadoVenta'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos['EstadoVenta']>1){
            return 204;
        }
        return DB::table('ventas')
                ->where('IdVenta', $datos['IdVenta'])
                ->update($values);
    }

    // Activar / Desactivar Detalle compra
    public function activarVentaDetalle($datos){
        $idAdmin = Auth::id();
        if ($datos[0]->EstadoVentaDetalle>0){
            $values=array('EstadoVentaDetalle'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoVentaDetalle'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('ventas_detalle')
                ->where('IdDetalleVenta', $datos[0]->IdDetalleVenta)
                ->update($values);
    }

    public function getCabeceraVenta($IdVenta){
        return DB::table('v_ventas')->where('IdVenta',$IdVenta)->get(); 
    }

    public function getDetallesVenta($IdVenta){
        return DB::table('v_ventas_detalle')->where('IdVenta',$IdVenta)->where('EstadoVentaDetalle',1)->get(); 
    }
    
	// Registrar Pago Venta
    public function regPagoVenta($datos){
        $idAdmin = Auth::id();
        $datos['IdDetallePago']==null ? $Id=0 : $Id= $datos['IdDetallePago'];
		
		$fpc = $datos['FechaPrimeraCuota']; 
		if($fpc == "") $fpc = date("d-m-Y");
		else $fpc = $this->formatearFecha($fpc);
		
        $sql="select f_registro_pago_ventas(".$Id.",".$datos['IdVentaPago'].",".$datos['IdFormaPago'].",'".$datos['CodigoAprobacionTarjeta']."','".$datos['NumeroTransaccionTarjeta']."','".$datos['IdClienteVC']."', '".$fpc."','".$datos['NumeroCuotasCredito']."','".$datos['InteresMensualCredito']."','".$datos['MontoFinalCredito']."','".$datos['MontoCuotaCredito']."','".$datos['MontoPagoEfectivo']."',1,".$idAdmin.")";
		//log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
	
	// Registrar Pago Punto Venta
    public function regPagoPuntoVenta($datos){
        $idAdmin = Auth::id();
		
		////log::info("IdPreVenta: " . $datos['IdPreVentaPago']);
		
        $datos['IdDetallePago']==null ? $Id=0 : $Id= $datos['IdDetallePago'];
		
		$fpc = $datos['FechaPrimeraCuota']; 
		if($fpc == "") $fpc = date("d-m-Y");
		else $fpc = $this->formatearFecha($fpc);
		
        $sql="select f_registro_pago_ventas(".$Id.",".$datos['IdPreVentaPago'].",".$datos['IdFormaPagoPreVenta'].",'".$datos['CodigoAprobacionTarjeta']."','".$datos['NumeroTransaccionTarjeta']."','".$datos['IdClienteVC']."', '".$fpc."','".$datos['NumeroCuotasCredito']."','".$datos['InteresMensualCredito']."','".$datos['MontoFinalCredito']."','".$datos['MontoCuotaCredito']."','".$datos['MontoPagoEfectivo']."',1,".$idAdmin.")";
		
        log::info("SQL: " . $sql);
		
        $execute=DB::select($sql);

        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }

        log::info("Result: " . $result);

        return $result;
    }
	
	public function regFinalizarVenta($IdVenta){
		$sql="select f_finaliza_venta(".$IdVenta.")";
		
        log::info($sql);
		$execute=DB::select($sql);
		
		foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
		////log::info($execute);
		
        //$result['IdVenta'] = 1;
		return $result;
	}
	
	public function getDetallePago($IdVenta){
        return DB::table('v_ventas_pagos')->where('IdVenta', $IdVenta)->get(); 
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

        log::info("antes: " . $d . " --> " . $fecha );

        return $fecha;
    }

    public function buscarCombos($datos){
        $result['v_local'] = DB::table('v_locales_combo')->where('id',$datos['IdLocal'])->get();
        $result['v_bodega'] = DB::table('v_bodegas_combo')->where('id',$datos['IdBodega'])->get();
        return $result;
    }
    
    public function getOneVentaDetalle($IdDetalleVenta){
        return DB::table('v_ventas_detalle')->where('IdDetalleVenta',$IdDetalleVenta)->get();
    }
	
	public function getOnePagoVenta($IdDetallePago){
        return DB::table('v_ventas_pagos')->where('IdDetallePago',$IdDetallePago)->first();
    }
	
	public function activarDetallePago($IdDetallePago){
		$IdAdmin = Auth::id();
		$values=array('EstadoPago'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$IdAdmin);
		return DB::table('ventas_pagos')->where('IdDetallePago', $IdDetallePago)->update($values);
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

    public function cerrarVenta($IdVenta){
        $IdAdmin = Auth::id();
		
        $values=array('EstadoVenta'=>2,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$IdAdmin);
		//log::info($values);
        return DB::table('ventas')
                ->where('IdVenta', $IdVenta)
                ->update($values);
    }

    public function AddPreventa($IdVenta,$preventas){
        $i=0;
        foreach ($preventas as $preventa) {
            $preventa['IdVenta2']=$IdVenta;
            $preventa['IdDetalleVenta']=null;
            $preventa['CantidadVenta']=$preventa['CantidadPreVenta'];
            $result[$i]=$this->regDetalleVenta($preventa);
            $i++;
        }
        return $result;
    }
	
	public  function cargaPreVenta($IdPreVenta, $IdLocal){
		$IdAdmin = Auth::id();
		
		$sql="select f_registro_venta_preventa(".$IdPreVenta.",".$IdLocal.",".$IdAdmin.")";
		////log::info($sql);
		
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
		
		return $result;
	}
	
}