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

class Local extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'locales';

    protected $primaryKey = 'IdLocal';

    protected $fillable = [
        'NombreLocal','IdEmpresa','IdEncargadoLocal','auUsuarioModificacion','auUsuarioCreacion','EstadoLocal'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar combo de perfiles de empresa
    public function listLocal(){
        return DB::table('v_locales')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // Cargar combo de Empresa
    public function listEmpresas(){
        return DB::table('v_empresas_combo')->get();
    }

    // registrar un nuevo empresa en la aplicacion
    public function regLocal($datos){
        $idAdmin = Auth::id();
        $datos['IdLocal']==null ? $Id=0 : $Id= $datos['IdLocal'];
        $sql="select f_registro_local(".$Id.",'".$datos['NombreLocal']."',".$datos['IdEmpresa'].",".$datos['IdEncargadoLocal'].",".$datos['EstadoLocal'].",".$datos['IdBodegaPrincipal'].",'".$datos['DireccionLocal']."','".$datos['UrlLogo']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_local']=$value;
        }
        return $result;
    }

    // Activar / Desactivar empresa
    public function activarLocal($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoLocal']>0){
            $values=array('EstadoLocal'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoLocal'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('locales')
                ->where('IdLocal', $datos['IdLocal'])
                ->update($values);
    }

    public function bodegasLocal($IdLocal){    
        $result['bodegas'] = DB::table('v_bodegas')->where('IdLocal',$IdLocal)->get(); 
        $sql="select SUM(MontoValorizado) as TotalValorizado from v_bodegas where IdLocal=".$IdLocal;
        $result['sum']=DB::select($sql);
        return $result;
    }

    public function bodegasPrincipalLocal($IdLocal){    
        return  DB::table('v_bodegas_combo')->where('IdLocal',$IdLocal)->get(); 
    }

    public function getOneDetalle($IdLocal){
        return DB::table('v_locales')->where('IdLocal',$IdLocal)->get(); 
    }  

}