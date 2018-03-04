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

use App\Models\Usuario;


class Cliente extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'clientes';

    protected $primaryKey = 'IdCliente';

    protected $fillable = [
        'RUTCliente', 'NombreCliente', 'DireccionCliente', 'DiaPago', 'CupoAutorizado', 'CupoUtilizado', 'EstadoCliente', 'auUsuarioModificacion', 'auUsuarioCreacion','IdCicloFacturacion'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listClientes(){
        return DB::table('v_clientes')->get();
    }

    // Cargar combo de estados de Estado (Activo / Inactivo)
    public function listEstados(){
        return DB::table('v_estados')->get();
    }

    // Cargar combo Familia
    public function listCiclos(){
        return DB::table('v_ciclos_facturacion_combo')->get();
    }

    // registrar una nuevo Cliente
    public function regCliente($datos){
        $model = new Usuario();
        $datos['RUTCliente'] = $model->LimpiarRut($datos['RUTCliente']);
        $idAdmin = Auth::id();
        $datos['IdCliente']==null ? $Id=0 : $Id= $datos['IdCliente'];
        $sql="select f_registro_cliente(".$Id.",'".$datos['RUTCliente']."','".$datos['NombreCliente']."','".$datos['DireccionCliente']."','".$datos['CupoAutorizado']."','".$datos['CupoUtilizado']."',".$datos['IdCicloFacturacion'].",".$datos['EstadoCliente'].",".$idAdmin.")";
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        return $result;
    }

    // Activar / Desactivar Cliente
    public function activarCliente($datos){
        $idAdmin = Auth::id();
        if ($datos['EstadoCliente']>0){
            $values=array('EstadoCliente'=>0,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }else{
            $values=array('EstadoCliente'=>1,'auFechaModificacion'=>date("Y-m-d H:i:s"),'auUsuarioModificacion'=>$idAdmin);
        }
        return DB::table('clientes')
                ->where('IdCliente', $datos['IdCliente'])
                ->update($values);
    }

    public function getDetallesClientes($IdCliente){
        return DB::table('v_clientes')->where('IdCliente',$IdCliente)->get();
    }
}