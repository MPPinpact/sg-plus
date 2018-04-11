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
    public function listProveedor(){
        return DB::table('v_proveedores')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // Cargar combo de Locales
    // public function listLocales(){
    //     return DB::table('v_locales_combo')->get();
    // }

    // registrar una nueva proveedor
    public function regProveedor($datos){
        $idAdmin = Auth::id();
        $datos['IdProveedor']==null ? $Id=0 : $Id= $datos['IdProveedor'];
        $sql="select f_registro_proveedor(".$Id.",'".$datos['RUTProveedor']."','".$datos['CodigoProveedor']."','".$datos['RazonSocialProveedor']."','".$datos['NombreFantasia']."','".$datos['Direccion']."','".$datos['Telefeno']."','".$datos['Vendedor']."',".$datos['EstadoProveedor'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar proveedor
    public function activarProveedor($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoProveedor']>0){
            $values=array('EstadoProveedor'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoProveedor'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('proveedores')
                ->where('IdProveedor', $datos['IdProveedor'])
                ->update($values);
    }

    public function localesProducto($IdBodega){
        return DB::table('v_productos')->where('IdBodega',$IdBodega)->get();
    }

    public function getOneDetalle($IdProveedor){
        return DB::table('v_proveedores')->where('IdProveedor',$IdProveedor)->get();
    }

}