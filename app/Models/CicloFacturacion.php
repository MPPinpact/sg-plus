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

class CicloFacturacion extends Authenticatable
{
    protected $table = 'ciclo_facturacion';

    protected $primaryKey = 'IdCicloFacturacion';

    protected $fillable = [
        'DiaCorte', 'DiaFacturacion', 'EstadoCiclo', 'auUsuarioModificacion', 'auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];
    
    public function listCicloFacturacion(){
        return DB::table('v_ciclos_facturacion')->get();
    }

    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    public function regCiclo($datos){
        $idAdmin = Auth::id();      
        $datos['IdCicloFacturacion']==null ? $Id=0 : $Id= $datos['IdCicloFacturacion'];  
        $sql="select f_registro_ciclo_facturacion(".$Id.",".$datos['DiaCorte'].",".$datos['DiaFacturacion'].",".$datos['EstadoCiclo'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    public function activarCiclo($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoCiclo']>0){
            $values=array('EstadoCiclo'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoCiclo'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('ciclo_facturacion')
                ->where('IdCicloFacturacion', $datos['IdCicloFacturacion'])
                ->update($values);
    }
}