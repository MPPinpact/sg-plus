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
}