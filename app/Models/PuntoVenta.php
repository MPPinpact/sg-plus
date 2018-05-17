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

class PuntoVenta extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'punto_venta';

    protected $primaryKey = 'IdPuntoVenta';

    protected $fillable = [
        'NombrePuntoVenta', 'DescripcionPuntoVenta', 'IdLocal', 'EstadoPuntoVenta'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listPuntoVenta(){
        return DB::table('v_punto_venta')->where('EstadoPuntoVenta',1)->get();
    }

    // registrar abono
    public function regPuntoVenta($datos){        
        $idAdmin = Auth::id();
        $result = array();

        return $result;
    }

    public function listOpcionesPuntoVenta($IdLocal){
        return DB::table('v_punto_venta_opciones')->where('IdLocal',$IdLocal)->first();


    }

    public function getOneDetalle($IdAbono){
        return DB::table('v_abono_cliente')->where('IdAbono',$IdAbono)->get();
    }

    public function regOpcionesPuntoVenta($datos){
        $IdUsuario = Auth::id();

        $IdPuntoVenta = isset($datos['IdPuntoVenta']) ? $datos['IdPuntoVenta'] : 'Null';
        $ManejaVendedor = isset($datos['checkboxMV']) ? '1' : '0';
        $IdVendedorDefault = isset($datos['SelectVendedores']) ? $datos['SelectVendedores'] : '1';
        $ManejaClientes = isset($datos['checkboxMC']) ? '1' : '0';
        $IdClienteDefault = '0';
        $TipoDctoVta = isset($datos['SelectDocumentoVTA']) ? $datos['SelectDocumentoVTA'] : 'Null';
        $FormasPago = isset($datos['SelectFormaPago']) ? implode(',', $datos['SelectFormaPago']) : Null;
        $NotaPedido = isset($datos['checkboxNV']) ? '1' : '0';
        $DTE = isset($datos['checkboxDTE']) ? '1' : '0';
        $DTEDefautl = isset($datos['SelectDTEPrincipal']) ? $datos['SelectDTEPrincipal'] : 'Null';
        $DescoUnidad = isset($datos['checkboxDesctoUnidad']) ? '1' : '0';
        $TipoDescoUnidad = isset($datos['checkboxTipoDesctoUnidad']) ? $datos['checkboxTipoDesctoUnidad'] : '0';
        $DescoUnidadMax = isset($datos['DescoUnidadMax']) ? $datos['DescoUnidadMax'] : '0';
        $DescoTotal = isset($datos['checkboxDesctoTotal']) ? '1' : '0';
        $TipoDescoTotal = isset($datos['checkboxTipoDesctoTotal']) ? $datos['checkboxTipoDesctoTotal'] : '0';
        $DescoTotalMax = isset($datos['DescoTotalMax']) ? $datos['DescoTotalMax'] : '0';
        $ManejaSTOCK = isset($datos['checkboxSTOCK']) ? '1' : '0';
        $AlertaBajoSTOCK = isset($datos['checkboxBajoSTOCK']) ? '1' : '0';
        $AlertaBajoMinimo = isset($datos['checkboxMinimoSTOCK']) ? '1' : '0';
        $VentaSinSTOCK = isset($datos['checkboxSinSTOCK']) ? '1' : '0';
        $BodegaSTOCK = isset($datos['SelectBodegaSTOCK']) ? $datos['SelectBodegaSTOCK'] : 'Null'; 

        $sql="select f_registro_opciones_pto_vta(" . $IdPuntoVenta . ", " . $ManejaVendedor . ", " . $IdVendedorDefault . ", " . $ManejaClientes . ", " . $IdClienteDefault . ", " . $TipoDctoVta  .", '" . $FormasPago . "', " . $NotaPedido . ", " . $DTE . ", " . $DTEDefautl . ", " . $DescoUnidad . ", " . $TipoDescoUnidad . ", '". $DescoUnidadMax . "', " . $DescoTotal ."," . $TipoDescoTotal . ", '" . $DescoTotalMax . "', " . $ManejaSTOCK . "," . $AlertaBajoSTOCK . ", " . $AlertaBajoMinimo . ", " . $VentaSinSTOCK . ", " . $BodegaSTOCK . ")";

        //log::info($sql);
        $execute=DB::select($sql);
        foreach ($execute[0] as $key => $value) {
            $result=$value;
        }
        
        return $result;
    }
}