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

class Credito extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'credito_preferencias';

    protected $primaryKey = 'IdCreditoPreferencia';

    protected $fillable = [
		'FechaInicio', 'FechaFin', 'InteresMensual', 'NumeroMaxCuotas', 'TolenranciaDiasPrimeraCuota', 'AdvertenciaDeudaVencida', 'MontoMantencionCuenta', 'EstadoPreferencia','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listPreferencias(){
        return DB::table('v_credito_preferencias')->get();
    }

    public function listCreditoVentas(){
        return DB::table('v_credito_ventas')->get();
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

    // registrar una nuevo Cliente
    public function regPreferencias($datos){
        $idAdmin = Auth::id();
        
        $datos['IdCreditoPreferencia']==null ? $Id=0 : $Id= $datos['IdCreditoPreferencia'];

        $datos['FechaInicio'] = $this->formatearFecha($datos['FechaInicio']);
        $datos['FechaFin'] = $this->formatearFecha($datos['FechaFin']);

        $sql="select f_registro_preferencia(".$Id.",'".$datos['FechaInicio']."','".$datos['FechaFin']."','".$datos['InteresMensual']."',".$datos['NumeroMaxCuotas'].",".$datos['TolenranciaDiasPrimeraCuota'].",".$datos['AdvertenciaDeudaVencida'].",'".$datos['MontoMantencionCuenta']."',".$datos['EstadoPreferencia'].",".$idAdmin.")";
        //Validador de Ingreso de Fechas
        $validador = 0;
        $model = new Credito();
        if($datos['EstadoPreferencia'] == 1){
            $validador = $model->validarPreferencia($datos['FechaInicio'],$datos['FechaFin']);
        }   
        if($validador > 0){
            return '{"code":"-2"}'; 
        }else{
            $execute=DB::select($sql);
            foreach ($execute[0] as $key => $value) {
                $result=$value;
            }
        }
        return $result;
    }

    // Activar / Desactivar Cliente
    public function activarCredito($datos){
        $model = new Credito();
        $validador = 0;
        if($datos['EstadoPreferencia'] == 0){
            $validador = $model->validarPreferencia($datos['FechaInicio'],$datos['FechaFin']);
        }    

        if($validador > 0){
             return '{"code":"-2"}'; 
        }else{
            $idAdmin = Auth::id();

            if ($datos['EstadoPreferencia']>0){
                $values=array('EstadoPreferencia'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
            }else{
                $values=array('EstadoPreferencia'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
            }
            return DB::table('credito_preferencias')
                    ->where('IdCreditoPreferencia', $datos['IdCreditoPreferencia'])
                    ->update($values);
        }
    }

     // Validacion de Preferencia de Credito activa para ese rango de fecha
    public function validarPreferencia($fInicio, $fFin){
        $sql = "select count(1) existe from credito_preferencias 
            WHERE ((FechaInicio <= '".$fInicio."'  AND FechaFin >= '".$fFin."')
            OR FechaInicio BETWEEN '".$fInicio."' AND '".$fFin."'
            OR FechaFin BETWEEN '".$fInicio."' AND '".$fFin."') and EstadoPreferencia = 1";

        $execute=DB::select($sql);
        return $execute[0]->existe;
    }

    public function getPreferenciaCredito($IdCreditoPreferencia){
        return DB::table('v_credito_preferencias')->where('IdCreditoPreferencia',$IdCreditoPreferencia)->get();
    }


    public function formatearFecha($d){
        $formato = explode("-", $d);
        $fecha = $formato[2]."-".$formato[1]."-".$formato[0];
        return $fecha;
    }
}