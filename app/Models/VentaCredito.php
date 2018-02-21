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
}