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

class AbonoCliente extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'abono_cliente';

    protected $primaryKey = 'IdAbono';

    protected $fillable = [
        'MontoAbono','FechaAbono','EstadoAbono','IdFormaPago'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listAbonoCliente(){
        return DB::table('v_abono_cliente')->where('EstadoAbono',1)->get();
    }

    public function listFormaPago(){
        return DB::table('v_forma_pago_combo')->get();
    }

    // registrar abono
    public function regAbonoCliente($datos){        
        $idAdmin = Auth::id();
        $datos['IdAbono']==null ? $Id=0 : $Id= $datos['IdAbono'];
        $datos['IdCaja']==null ? $IdCaja=0 : $IdCaja=$datos['IdCaja'];

        // log::info($datos);

        $sql="select f_registro_abono(".$Id.",".$datos['IdClienteAbono']."," . $IdCaja . ",'".$datos['MontoAbono']."',".$datos['IdFormaPago'].",".$idAdmin.")";

        // log::info($sql);

        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    public function regPagoCredito($datos){
        $idAdmin = Auth::id();
        $Id=0;
        $datos['IdCajaPC'] == null ? $IdCaja = 0 : $IdCaja = $datos['IdCajaPC'];

        $sql="select f_registro_abono(" . $Id . "," . $datos['IdClientePagoCredito'] . "," . $IdCaja . ",'" . $datos['MontoAPagarPagoCredito'] . "'," . $datos['IdFormaPagoCredito'] . "," . $idAdmin . ")";

        //log::info($sql);

        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar abono
    public function activarAbonoCliente($datos){
        $idAdmin = Auth::id();
        if ($datos->EstadoAbono > 0){
            $values=array('EstadoAbono'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
            $values2=array('EstadoMovimiento'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        // else{
        //     $values=array('EstadoAbono'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        // }
        $sql = DB::table('clientes_movimientos')
                ->where('NumeroDocumento', $datos->IdAbono)
                ->update($values2);

        return DB::table('abono_cliente')
                ->where('IdAbono', $datos->IdAbono)
                ->update($values);
    }

    public function getOneDetalle($IdAbono){
        return DB::table('v_abono_cliente')->where('IdAbono',$IdAbono)->get();
    }
}