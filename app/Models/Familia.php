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

class Familia extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'familia';

    protected $primaryKey = 'IdFamilia';

    protected $fillable = [
        'NombreFamilia','auUsuarioModificacion','auUsuarioCreacion','EstadoFamilia'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];


    // Cargar tabla de bodega
    public function listFamilia(){
        return DB::table('v_familia')->get();
    }

    public function listFamiliasActivas(){
        return DB::table('v_familia')->where('EstadoFamilia', 1)->orderBy('IdFamilia')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // registrar familia
    public function regFamilia($datos){
        $idAdmin = Auth::id();
        $datos['IdFamilia']==null ? $Id=0 : $Id= $datos['IdFamilia'];
        $sql="select f_registro_familia(".$Id.",'".$datos['NombreFamilia']."',".$datos['EstadoFamilia'].",".$idAdmin.")";
        $execute=DB::select($sql);
        
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_familia']=$value;
        }
        return $result;
    }

    // Activar / Desactivar Familia
    public function activarFamilia($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoFamilia']>0){
            $values=array('EstadoFamilia'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoFamilia'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('familia')
                ->where('IdFamilia', $datos['IdFamilia'])
                ->update($values);
    }
}