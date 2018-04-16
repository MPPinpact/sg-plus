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

class FormaPago extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'formas_pago';

    protected $primaryKey = 'IdFormaPago';

    protected $fillable = [
        'NombreFormaPago','EstadoFormaPago','auUsuarioModificacion','auUsuarioCreacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    // Cargar tabla de bodega
    public function listProveedor(){
        return DB::table('v_proveedores')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }
    // Cargar combo formas de pago 
    public function listFormaspago(){
        return DB::table('v_formas_de_pago')->get();
    }

    public function listRegFormaspago(){
        return DB::table('v_formas_pago')->get();
    }

    // Cargar combo de Locales
    public function listLocales(){
        return DB::table('v_locales_combo')->get();
    }

    // registrar una nueva proveedor
    public function regProveedor($datos){        
        log::info($datos);
        $idAdmin = Auth::id();
        $datos['IdFormaPago']==null ? $Id=0 : $Id= $datos['IdFormaPago'];
        $sql="select f_registro_formapago(".$Id.",'".$datos['pNombreFormaPago']."',".$idAdmin.")";
        log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }

        // log::info($execute);
        // Para probar
        //return $result;
        
    }

    // Activar / Desactivar proveedor
    public function activarProveedor($datos){
        
        $idAdmin = Auth::id();
        if ($datos['EstadoFormaPago']>0){
            $values=array('EstadoFormaPago'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        log::info('Mayor a 0'.$datos);
        }else{
            $values=array('EstadoFormaPago'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        log::info('Igual a 0'.$datos);
        }
        return DB::table('formas_pago')
                ->where('EstadoFormaPago', $datos['EstadoFormaPago'])
                ->update($values);
    }

    public function localesProducto($IdBodega){
        return DB::table('v_productos')->where('IdBodega',$IdBodega)->get();
    }

    public function getOneDetalle($IdFormaPago){
        return DB::table('v_formas_pago')->where('IdFormaPago',$IdFormaPago)->get();
    }

}



