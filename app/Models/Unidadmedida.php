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

class Unidadmedida extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'unidadmedida';

    protected $primaryKey = 'IdUnidadMedida';

    protected $fillable = [
        'NombreUnidadMedida','auUsuarioModificacion','auUsuarioCreacion','EstadoUnidadMedida'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de bodega
    public function listUnidad(){
        return DB::table('v_unidadmedida')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // registrar una nueva unidad
    public function regUnidad($datos){
        $idAdmin = Auth::id();
        $datos['IdUnidadMedida']==null ? $Id=0 : $Id= $datos['IdUnidadMedida'];
        $sql="select f_registro_unidadmedida(".$Id.",'".$datos['NombreUnidadMedida']."',".$datos['EstadoUnidadMedida'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_unidadmedida']=$value;
        }
        return $result;
    }

    // Activar / Desactivar Unidad
    public function activarUnidad($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoUnidadMedida']>0){
            $values=array('EstadoUnidadMedida'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoUnidadMedida'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('unidadmedida')
                ->where('IdUnidadMedida', $datos['IdUnidadMedida'])
                ->update($values);
    }
}