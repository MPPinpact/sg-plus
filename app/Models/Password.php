<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\QueryException;
use App\Exceptions\Handler;

use DB;
use Crypt;
use Hash;
use Log;
use DateTime;
use Session;

// Modelo
use App\Models\Usuario;


class Password extends Authenticatable{

    public function recuperarPassword($datos){
        $model= new Usuario();
        $result = $model->cambiarPassword($datos);
        return $result; 
    }
}