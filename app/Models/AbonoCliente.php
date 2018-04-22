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

    public function listFormasPago(){
        return DB::table('v_abonocliente')->get();
    }

    // registrar una nueva proveedor
    public function regFormaPago($datos){        
        $idAdmin = Auth::id();
        $datos['IdCliente']==null ? $Id=0 : $Id= $datos['IdCliente'];
        $sql="select f_registro_formapago(".$Id.",'".$datos['NombreFormaPago']."',".$idAdmin.")";
        Log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar proveedor
    public function activarFormaPago($datos){
        $idAdmin = Auth::id();
        if ($datos->EstadoFormaPago > 0){
            $values=array('EstadoFormaPago'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoFormaPago'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('formas_pago')
                ->where('IdCliente', $datos->IdCliente)
                ->update($values);
    }

    public function getOneDetalle($IdCliente){
        return DB::table('v_abonocliente')->where('IdCliente',$IdCliente)->get();
    }
}
