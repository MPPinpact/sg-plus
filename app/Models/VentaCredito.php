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

class VentaCredito extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */

    protected $table = 'credito_venta';

    protected $primaryKey = 'IdVentaCredito';

    protected $fillable = [
		'IdVenta', 'IdCliente', 'FechaVentaCredito', 'MontoCredito', 'NumeroCuotas', 'InteresMensual', 'MontoFinal', 'MontoCuota', 'PrimeraCuota'
    ];

    protected $dates = [
        'auFechaModificacion','auFechaCreacion'
    ];

    public function listVentaCredito(){
        return DB::table('v_credito_ventas')->get();
    }

    public function listEstados(){
        return DB::table('v_estados')->get();
    }
	
}