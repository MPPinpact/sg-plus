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

class Subfamilia extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'subfamilias';

    protected $primaryKey = 'IdSubFamilia';

    protected $fillable = [
        'NombreSubFamilia','IdUnidadMedida','auUsuarioModificacion','auUsuarioCreacion','EstadoSubFamilia',
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];



    // Cargar tabla de bodega
    public function listSubfamilia(){
        return DB::table('v_subfamilia')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // Cargar combo de unidades de medidas registradas
    public function listUnidadmedida(){
        return DB::table('v_unidadmedida_combo')->get();
    }
    

    // registrar familia
    public function regSubfamilia($datos){
        $idAdmin = Auth::id();
        $datos['IdSubFamilia']==null ? $Id=0 : $Id= $datos['IdSubFamilia'];
        $sql="select f_registro_subfamilias(".$Id.",'".$datos['NombreSubFamilia']."',".$datos['IdUnidadMedida'].",".$datos['EstadoSubFamilia'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_subfamilias']=$value;
        }
        return $result;
    }

    // Activar / Desactivar Familia
    public function activarSubfamilia($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoSubFamilia']>0){
            $values=array('EstadoSubFamilia'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoSubFamilia'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('subfamilias')
                ->where('IdSubFamilia', $datos['IdSubFamilia'])
                ->update($values);
    }
}