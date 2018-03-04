<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\QueryException;
use App\Exceptions\Handler;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;

use DB;
use Log;
use DateTime;
use Session;
use Exception;
use Auth;

class VentaCredito extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'credito_venta';

    protected $primaryKey = 'IdVentaCredito';

    protected $fillable = [
        'IdVenta', 'IdCliente', 'FechaVentaCredito', 'MontoCredito', 'NumeroCuotas', 'InteresMensual', 'MontoFinal', 'MontoCuota', 'PrimeraCuota', 'EstadoVentaCredito'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listVentaCredito(){
        return DB::table('v_credito_ventas')->get();
    }

    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    public function listClientesCombo(){
        return DB::table('v_cliente_combo')->get();
    }

    public function listPrefenciActiva(){
        return DB::table('v_credito_preferencias')->where('EstadoPreferencia',1)->get();
        //return DB::table('v_credito_preferencias')->get();
    }

    public function regVentaCredito($datos){
        $idAdmin = Auth::id();
        $datos['PrimeraCuota'] = $this->formatearFecha($datos['PrimeraCuota']);
        $datos['IdVentaCredito']==null ? $Id=0 : $Id= $datos['IdVentaCredito'];
        $sql="select f_registro_venta_credito(".$Id.",".$datos['IdVenta'].",".$datos['IdCliente'].",'".$datos['MontoCredito']."',".$datos['NumeroCuotas'].",'".$datos['InteresMensual']."','".$datos['MontoFinal']."','".$datos['MontoCuota']."','".$datos['PrimeraCuota']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        $movimiento = $this->regMovimiento($datos,$result);
        return $result;
    }

    public function regMovimiento($datos,$res){
        $idAdmin = Auth::id();
        $res = json_decode($res, true);
        if($res['code']==200){
            $fecha = $datos['PrimeraCuota'];
            $formato = explode("-", $fecha);
            $fechaCuota  = Carbon::createFromDate($formato[0],$formato[1],$formato[2]);
            for ($i=0; $i < $datos['NumeroCuotas'] ; $i++) {
                $values=array('IdCliente'=>$datos['IdCliente'],
                              'FechaMovimiento'=>date("Y-m-d H:i:s"),
                              'NumeroDocumento'=>$datos['IdVenta'],
                              'TipoMovimiento'=>'1',
                              'DescripcionMovimiento'=>'Venta Credito valor cuota '.$i,
                              'MontoMovimiento'=>$datos['MontoCuota'],
                              'FechaVencimiento'=>$fechaCuota,
                              'EstadoMovimiento'=>'1',
                              'auFechaCreacion'=>date("Y-m-d H:i:s"),
                              'auUsuarioCreacion'=>$idAdmin);
                $fechaCuota = $fechaCuota->addMonth();
                DB::table('clientes_movimientos')->insert($values);
            }
        }
    }

    public function formatearFecha($d){
        $formato = explode("-", $d);
        $fecha = $formato[2]."-".$formato[1]."-".$formato[0];
        return $fecha;
    }

    // Activar / Desactivar Cliente
    public function activarVentaCredito($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoVentaCredito']>0){
            $values=array('EstadoVentaCredito'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoVentaCredito'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('credito_venta')
                ->where('IdVentaCredito', $datos['IdVentaCredito'])
                ->update($values);
    }

    public function getDetallesVentaCredito($IdVentaCredito){
        return DB::table('v_credito_ventas')->where('IdVentaCredito',$IdVentaCredito)->get();
    }

    public function getOneCliente($RUTCliente){
        return DB::table('v_clientes')->where('RUTCliente',$RUTCliente)->get();
    }

    public function calcularFechaPago($cliente){
        //$date = Carbon::now();
        $date  = Carbon::createFromDate(2018,01,27);
        $fechaVenta = $date->format('d/m/Y');
        $diaVenta = $date->format('d');
        $diaPago = $cliente[0]->DiaPago;
        $diaFacturacion= $cliente[0]->DiaFacturacion;
        $mesVenta = $date->format('m');
        $mesPago = 0;
        $mesFacturacion = 0;
        $anioVenta = $date->format('Y');
        $anioPago = 0;
        $anioFacturacion = 0;

        if ($diaVenta < $diaFacturacion){

            // Si el dia de venta es menor entonces la fecha de facturacion es el mismo mes
            $mesFacturacion = $mesVenta;
            $anioFacturacion = $anioVenta;
            $fechaFacturacionTemp = Carbon::createFromDate($anioFacturacion,$mesFacturacion,$diaFacturacion);
            $fechaFacturacion = $fechaFacturacionTemp->format('d-m-Y');

            //Calcular la fecha de Pago sumando un mes a la fecha de facturacion
            $fechaPagoTemp = $fechaFacturacionTemp->addMonth();
            $mesPagoTemp = $fechaPagoTemp->format('m');
            $anioPagoTemp = $fechaPagoTemp->format('Y');
            $fechaPago = Carbon::createFromDate($anioPagoTemp,$mesPagoTemp,$diaPago);
            $fechaPago = $fechaPago->format('d-m-Y');

        }else{

            // Si el dia de venta es mayor al de facturacion entonces la fecha de facturacion se le suma un mes
            $fechaFacturacionTemp = $date->addMonth();
            $mesFacturacionTemp = $fechaFacturacionTemp->format('m');
            $anioFacturacionTemp =  $fechaFacturacionTemp->format('Y');
            $fechaFacturacionTemp = Carbon::createFromDate($anioFacturacionTemp,$mesFacturacionTemp,$diaFacturacion);
            $fechaFacturacion = $fechaFacturacionTemp->format('d-m-Y');

            //Calcular la fecha de Pago sumando un mes a la fecha de facturacion
            $fechaPagoTemp = $fechaFacturacionTemp->addMonth();
            $mesPagoTemp = $fechaPagoTemp->format('m');
            $anioPagoTemp = $fechaPagoTemp->format('Y');
            $fechaPago = Carbon::createFromDate($anioPagoTemp,$mesPagoTemp,$diaPago);
            $fechaPago = $fechaPago->format('d-m-Y');

        }

        $result['fechaVenta'] = $date;
        $result['fechaPago'] = $fechaPago;
        $result['fechaFacturacion'] = $fechaPago;
        return $result;
    }
}








/*

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

class VentaCredito extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

   /* protected $table = 'credito_venta';

    protected $primaryKey = 'IdVentaCredito';

    protected $fillable = [
		'IdVenta', 'IdCliente', 'FechaVentaCredito', 'MontoCredito', 'NumeroCuotas', 'InteresMensual', 'MontoFinal', 'MontoCuota', 'PrimeraCuota', 'EstadoVentaCredito'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listVentaCredito(){
        return DB::table('v_credito_ventas')->get();
    }

    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    public function listClientesCombo(){
        return DB::table('v_cliente_combo')->get();
    }

    public function regVentaCredito($datos){
        $idAdmin = Auth::id();
        $datos['IdVentaCredito']==null ? $Id=0 : $Id= $datos['IdVentaCredito'];
        $sql="select f_registro_venta_credito(".$Id.",".$datos['IdVenta'].",".$datos['IdCliente'].",'".$datos['MontoCredito']."',".$datos['NumeroCuotas'].",'".$datos['InteresMensual']."','".$datos['MontoFinal']."','".$datos['MontoCuota']."','".$datos['PrimeraCuota']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar Cliente
    public function activarVentaCredito($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoVentaCredito']>0){
            $values=array('EstadoVentaCredito'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoVentaCredito'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('credito_venta')
                ->where('IdVentaCredito', $datos['IdVentaCredito'])
                ->update($values);
    }

    public function getDetallesVentaCredito($IdVentaCredito){
        return DB::table('v_credito_ventas')->where('IdVentaCredito',$IdVentaCredito)->get();
    }
}*/