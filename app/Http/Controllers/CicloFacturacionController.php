<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Form;
use Lang;
use View;
use Redirect;
use SerializesModels;
use Log;
use Session;
use Config;
use Mail;
use Storage;
use DB;

use App\Models\CicloFacturacion;
use App\Models\Usuario;

class CicloFacturacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCicloFacturacionl()
    {
        $model= new CicloFacturacion();
        $data['v_ciclos_facturacion'] = $model->listCicloFacturacion();
        $data['v_estados'] = $model->listEstados();
        return View::make('cicloFacturacion.cicloFacturacion',$data);
    }
	
}
