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

class Home extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'v_dashboard_ventas';

    protected $primaryKey = 'IdVenta';

    protected $fillable = [
        'IdLocal','NombreLocal','IdCaja', 'IdCliente','IdVendedor','NombreVendedor','FechaVenta','Semana','Mes','Agno','TotalVenta','EstadoVenta','DesEstadoVenta'
    ];


    // Cargar combo de perfiles de empresa
    public function resumenVentaLocal($tiempo){
        switch ($tiempo) {
            case 'Y':
                 return DB::table('v_dashboard_ventas')->select(DB::raw('NombreLocal, Agno, SUM(TotalVenta) AS TotalVenta'))->whereRaw('Agno = YEAR(Now())')->groupBy('IdLocal')->get();
                break;
            case 'M':
                 return DB::table('v_dashboard_ventas')->select(DB::raw('NombreLocal, Mes, SUM(TotalVenta) AS TotalVenta'))->whereRaw('Mes = MONTH(Now())')->groupBy('IdLocal')->get();
                break;
            case 'W':
                 return DB::table('v_dashboard_ventas')->select(DB::raw('NombreLocal, Semana, SUM(TotalVenta) AS TotalVenta'))->whereRaw('Semana = WEEK(NOW())')->groupBy('IdLocal')->get();
                break;
            case 'D':
                 return DB::table('v_dashboard_ventas')->select(DB::raw('NombreLocal, FechaVenta, SUM(TotalVenta) AS TotalVenta'))->whereRaw('DATE_FORMAT(FechaVenta, "%Y-%m-%d") = DATE_FORMAT(NOW(), "%Y-%m-%d")')->groupBy('IdLocal')->get();
                break;

        }

       
    }

    public function resumenVentaVendedores(){
        return DB::table('v_dashboard_score_vendedores')->where('EstadoMeta','=', 1)->get();
    }
    

}