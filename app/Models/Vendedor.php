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


class Vendedor extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'vendedores';

    protected $primaryKey = 'IdVendedor';

    protected $fillable = [
        'RUTVendedor','NombreVendedor','ComisionVendedor','EstadoVendedor','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de bodega
    public function listVendedor(){
        return DB::table('v_vendedores')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // registrar una nueva vendedor
    public function regVendedor($datos){
        $idAdmin = Auth::id();
        $datos['IdVendedor']==null ? $Id=0 : $Id= $datos['IdVendedor'];
        $sql="select f_registro_vendedor(".$Id.",'".$datos['RUTVendedor']."','".$datos['NombreVendedor']."','".$datos['ComisionVendedor']."',".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }


    // Activar / Desactivar vendedor
    public function activarVendedor($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoVendedor']>0){
            $values=array('EstadoVendedor'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoVendedor'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('vendedores')
                ->where('IdVendedor', $datos['IdVendedor'])
                ->update($values);
    }

    public function getOneDetalle($IdVendedor){
        return DB::table('v_vendedores')->where('IdVendedor',$IdVendedor)->get();
    }

}