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

class Impuesto extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'impuestos';

    protected $primaryKey = 'IdImpuesto';

    protected $fillable = [
        'NombreImpuesto', 'ValorImpuesto', 'auUsuarioModificacion', 'auUsuarioCreacion', 'EstadoImpuesto'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de impuesto
    public function listImpuesto(){
        return DB::table('v_impuestos')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // registrar impuesto
    public function regImpuesto($datos){
        $idAdmin = Auth::id();
        $datos['IdImpuesto']==null ? $Id=0 : $Id= $datos['IdImpuesto'];
        $sql="select f_registro_impuesto(".$Id.",'".$datos['NombreImpuesto']."','".$datos['ValorImpuesto']."',".$datos['EstadoImpuesto'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_impuesto']=$value;
        }
        return $result;
    }

    // Activar / Desactivar Impuesto
    public function activarImpuesto($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoImpuesto']>0){
            $values=array('EstadoImpuesto'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoImpuesto'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('impuestos')
                ->where('IdImpuesto', $datos['IdImpuesto'])
                ->update($values);
    }
}