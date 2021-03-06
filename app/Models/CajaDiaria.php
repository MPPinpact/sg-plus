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

class CajaDiaria extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'caja_diaria';
    protected $primaryKey = 'IdCaja';

    protected $fillable = [
        'IdLocal','IdUsuario','EstadoArqueo','FechaArqueo','FechaApertura','FechaCierre','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de impuesto
    public function listCajasDiarias($IdLocal){
        return DB::table('v_cajas_diarias')->where('EstadoCaja', '>', 0)->where('IdLocal', $IdLocal)->get();
    }

    public function listFormasPago(){
        return DB::table('v_forma_pago_combo_credito')->get();        
    }
	
	// 
    public function resumenVentas($IdVenta){
		//log::info("Modelo Cajas Diarias --> resumenVentas");
		return DB::table('v_resumen_ventas')->where('IdCaja', '=', $IdVenta)->groupBy('FormaPago')->get();
    }

	// 
    public function resumenVentasDetallePago($IdVenta){
		//log::info("Modelo Cajas Diarias --> resumenVentasDetallePago");
		return DB::table('v_resumen_ventas')->where('IdCaja', '=', $IdVenta)->groupBy('FormaPago')->get();
    }

	// 
    public function resumenPagos($IdVenta){
		//log::info("Modelo Cajas Diarias --> resumenPagos");
        return DB::table('v_resumen_ventas')->where('IdCaja', '=', $IdVenta)->get();
    }
	
	// 
    public function resumenOM($IdVenta){
		//log::info("Modelo Cajas Diarias --> resumenOM");
        return DB::table('v_resumen_ventas')->where('IdCaja', '=', $IdVenta)->get();
    }
	
	// 
    public function getCajaActivaLocal($IdLocal){
		////log::info("Modelo Cajas Diarias --> getCajaActivaLocal");
        return DB::table('v_cajas_abiertas')->where('IdLocal', '=', $IdLocal)->get();
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

    public function listCajasDiariasResumen($IdCaja){
        return DB::table('v_resumen_caja')->where('IdCaja', $IdCaja)->orderBy('IdFormaPago', 'ASC')->get();
    }
	
	public function listResumenCajasDiaria($IdCaja){
        return DB::table('v_resumen_caja')->where('IdCaja', $IdCaja)->orderBy('IdFormaPago', 'ASC')->get(); 
    }
	
	public function listResumenRecaudacionCajasDiaria($IdCaja){
        return DB::table('v_cajas_diarias_recaudacion')->where('IdCaja', $IdCaja)->orderBy('Item', 'ASC')->get(); 
    }
	
	public function listDetallePagoCajasDiaria($IdCaja){
        return DB::table('v_abono_cliente')->where('IdCaja', $IdCaja)->orderBy('IdAbono', 'ASC')->get(); 
    }
	
	public function listDetalleVentaFormaPago($IdCaja, $IdFormaPago){
        return DB::table('v_resumen_ventas')->where([ ['IdCaja', '=', $IdCaja], ['IdFormaPago','=',$IdFormaPago]])->orderBy('IdVenta', 'ASC')->get(); 
	
    }
	
	public function listDetalleVentaCajaDiaria($IdCaja){
        return DB::table('v_resumen_ventas')->where([ ['IdCaja', '=', $IdCaja]])->orderBy('IdVenta', 'ASC')->get(); 
		
    }
	
    // registrar Venta
    public function regVenta($datos){
        $idAdmin = Auth::id();
        $datos['IdVenta']==null ? $Id=0 : $Id= $datos['IdVenta'];
        $datos['IdCliente']==null ? $datos['IdCliente']=0 : $datos['IdCliente']= $datos['IdCliente'];
        $datos['FechaVenta'] = $this->formatearFecha($datos['FechaVenta']);
        $sql="select f_registro_venta(".$Id.",".$datos['IdCliente'].",".$datos['IdVendedor'].",".$datos['IdLocal'].",".$datos['IdCaja'].",'".$datos['FechaVenta']."',".$idAdmin.")";
        //log::info($sql);
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

    // Activar / Desactivar Venta
    public function activarVenta($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoVenta']==1){
            $values=array('EstadoVenta'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        if ($datos['EstadoVenta']==0){
            $values=array('EstadoVenta'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('ventas')
                ->where('IdVenta', $datos['IdVenta'])
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

    public function getCabeceraVenta($IdVenta){
        return DB::table('v_ventas')->where('IdVenta',$IdVenta)->get(); 
    }

    public function getDetallesVenta($IdVenta){
        return DB::table('v_ventas_detalle')->where('IdVenta',$IdVenta)->get(); 
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
	
	public function regFinalizarVenta($IdVenta){
		$sql="select f_finaliza_venta(".$IdVenta.")";
		//log::info($sql);
		
		$execute=DB::select($sql);
		//log::info($execute);
		
		return "{IdVenta, 1}";
		//return DB::select($sql);
		
		//return DB::table('v_ventas_pagos')->where([['IdVenta', '=', $IdVenta],['IdFormaPago', '=', 3],])->get(); 
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
        //log::info("cerrarVenta()");
        //log::info($IdVenta);
		
        $IdAdmin = Auth::id();
        $values=array('EstadoVenta'=>2,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$IdAdmin);
		
		//log::info($values);
		
        return DB::table('ventas')
                ->where('IdVenta', $IdVenta)
                ->update($values);
    }
	
	public function cerrarCajaDiaria($IdCaja, $MontoCierre){
        //log::info("cerrarCajaDiaria()");
        //log::info("IdCaja: " .$IdCaja);
		
        // $IdAdmin = Auth::id();
        
        // $values=array('EstadoCaja'=>2,'FechaCierre'=>date("Y-m-d H:i:s"),'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$IdAdmin);

        // return DB::table('caja_diaria')->where('IdCaja', $IdCaja)->update($values);
        date_default_timezone_set('America/Santiago'); 
        
        $IdAdmin = Auth::id();
        $FechaCierre = date('Y-m-d H:i:s');

        $sql="select f_caja_diaria_cerrar(".$IdCaja.",".$IdAdmin.",'".$FechaCierre."','".$MontoCierre."')";
        log::info($sql);

        $execute=DB::select($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }

        return $result;

    }
	
	public function abrirCajaDiaria($IdLocal){
        //log::info("abrirCajaDiaria()");
        //log::info("IdLocal: " .$IdLocal);
		
        $IdUsuario = Auth::id();
		 		
		$sql="select f_caja_diaria_abrir(".$IdLocal.",".$IdUsuario.")";
        $execute=DB::select($sql);
		//log::info($sql);
		
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }
}
