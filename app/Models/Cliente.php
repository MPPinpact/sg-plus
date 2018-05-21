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
        return DB::table('v_estados_clientes')->get();
    }

    // Cargar combo Familia
    public function listCiclos(){
        return DB::table('v_ciclos_facturacion_combo')->get();
    }

    // registrar una nuevo Cliente
    public function regCliente($datos){
        $model = new Usuario();
        $idAdmin = Auth::id();
        $datos['RUTCliente'] = $model->LimpiarRut($datos['RUTCliente']);
        // $datos['EstadoCliente'] = 1;
        $datos['IdCliente']==null ? $Id=0 : $Id= $datos['IdCliente'];
        $datos['CupoUtilizado']==null ? $datos['CupoUtilizado']=0 : $datos['CupoUtilizado']= $datos['IdCliente'];
        // log::info($datos);
        $sql="select f_registro_cliente(".$Id.",'".$datos['RUTCliente']."','".$datos['NombreCliente']."','".$datos['DireccionCliente']."','".$datos['TelefonoCliente']."','".$datos['CupoAutorizado']."','".$datos['CupoUtilizado']."',".$datos['IdCicloFacturacion'].",".$datos['EstadoCliente'].",".$idAdmin.")";
        // log::info($sql);
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

    public function listMovimientos($IdCliente){
        $sql="SELECT * FROM v_clientes_movimientos WHERE IdCliente=".$IdCliente." AND EstadoMovimiento=1 ORDER BY FechaMovimiento DESC";
        //log::info($sql);
        $result=DB::select($sql);
        return $result;
    }

    public function listMovimientosUltimoEECC($IdCliente){
        // $sql="SELECT IdEECC, IdMovimiento, FechaMovimiento, NumeroDocumento, TipoMovimiento, DescripcionMovimiento, MontoMovimiento FROM  v_clientes_eecc_detalle WHERE IdEECC = (SELECT IdEECC FROM clientes_eecc WHERE IdCliente=".$IdCliente." ORDER BY FechaCorte DESC LIMIT 1);";
        // //log::info($sql);
        // $result=DB::select($sql);
        // return $result;
    }

    public function listMovimientosProximoEECC($IdCliente){
        $sql="SELECT IdMovimiento, FechaMovimiento, FechaVencimiento, NumeroDocumento, TipoMovimiento, DescripcionMovimiento, MontoMovimiento FROM  v_clientes_movimientos cm WHERE cm.IdCliente = ".$IdCliente." AND FechaVencimiento = (SELECT fechaProximaCuota FROM v_clientes cl WHERE cl.IdCliente = cm.IdCliente);";
        //log::info($sql);
        $result=DB::select($sql);
        return $result;
    }

    public function listeecc($IdCliente){
        $sql="select * from v_clientes_eecc where IdCliente=".$IdCliente." and EstadoEECC=1 order by IdEECC desc";
        $result=DB::select($sql);
        return $result;
    }

    public function buscarClienteDetalleCredito($datos){
        $cliente = DB::table('v_clientes')->where('RUTCliente',$datos['RUTCliente'])->get();
        $result = [];
        //log::info($cliente);
        if ($cliente){
            $result['cliente'] =$cliente;
            
            $result['UltimaCompra'] = DB::select("select CONCAT(TotalVenta,' / ', date_format(FechaVenta,'%d-%m-%Y')) as TotalVenta from v_ventas where IdCliente = ".$cliente[0]->IdCliente." order by IdVenta desc limit 1");
            
            $result['MontoAnterior'] = DB::select("select CONCAT(MontoFacturadoAnterior,' / ',date_format(FechaVencimiento,'%d-%m-%Y')) as MontoFacturadoAnterior from clientes_eecc where IdCliente = ".$cliente[0]->IdCliente." order by IdEECC desc limit 1");
            
            $result['MontoActual'] = DB::select("select MontoFacturadoActual from clientes_eecc where IdCliente = ".$cliente[0]->IdCliente." order by IdEECC desc limit 1");
            
            $result['UltimoPago'] = DB::select("select CONCAT(MontoAbono,' / ', date_format(FechaAbono,'%d-%m-%Y')) as MontoAbono from abono_cliente where IdCliente = ".$cliente[0]->IdCliente." and IdAbono in (select max(IdAbono) from abono_cliente where IdCliente = ".$cliente[0]->IdCliente.")");
            
            $result['FechaVencimiento'] = DB::select("select FechaVencimiento from clientes_eecc where IdCliente = ".$cliente[0]->IdCliente." order by IdEECC desc limit 1");
            
            $result['CupoAutorizado'] = DB::select("select CupoAutorizado from clientes where IdCliente= ".$cliente[0]->IdCliente.";");
            
            $result['DeudaTotal'] = DB::select("select CupoUtilizado from clientes where IdCliente= ".$cliente[0]->IdCliente.";");
        }
        return $result;
    }
}


