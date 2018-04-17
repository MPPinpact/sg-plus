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

class Empresa extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'empresas';

    protected $primaryKey = 'IdEmpresa';

    protected $fillable = [
        'RUT','RazonSocial','NombreFantasia','Giro','IdRepresentanteLegal','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de empresa
    public function listEmpresa(){
        return DB::table('v_empresas')->get();
    }

    // Cargar combo de estados de empresa (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // registrar un nuevo empresa en la aplicacion
    public function regEmpresa($datos){
        $idAdmin = Auth::id();
        $datos['IdEmpresa']==null ? $Id=0 : $Id= $datos['IdEmpresa'];
        $sql="select f_registro_empresa(".$Id.",'".$datos['RUT']."','".$datos['RazonSocial']."','".$datos['NombreFantasia']."','".$datos['Giro']."',".$datos['IdRepresentanteLegal'].",".$datos['EstadoEmpresa'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result['f_registro_empresa']=$value;
        }
        return $result;
    }

    // Activar / Desactivar empresa
    public function activarEmpresa($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoEmpresa']>0){
            $values=array('EstadoEmpresa'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoEmpresa'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('empresas')
                ->where('IdEmpresa', $datos['IdEmpresa'])
                ->update($values);
    }

    public function localesEmpresa($IdEmpresa){    
        // return DB::table('v_locales')->where('IdEmpresa',$IdEmpresa)->get(); 
        $result['locales'] =  DB::table('v_locales')->where('IdEmpresa',$IdEmpresa)->get(); 
        $sql="select SUM(MontoValorizado) as TotalValorizado from v_locales where IdEmpresa=".$IdEmpresa;
        $result['sum']=DB::select($sql);
        return $result;
    }

    public function getOneDetalle($IdEmpresa){
        return DB::table('v_empresas')->where('IdEmpresa',$IdEmpresa)->get(); 
    }  

}