<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use DateTime;

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

use App\Models\Local;
use App\Models\Usuario;

class LocalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getLocal()
    {
        $model= new Local();
        $data['v_locales'] = $model->listLocal();
        $data['v_empresas'] = $model->listEmpresas();
        $data['v_estados'] = $model->listEstados();
        return View::make('locales.locales',$data);
    }

    //Registrar o actualizar local
    protected function postLocal(Request $request){
        $archivo = $request->file('img');
        $datos = $request->all();
        $user= new Usuario();
        $model= new Local();
        $fotoOld = $request->input('urlImage');
        $input  = array('foto' => $archivo) ;
        if (isset($archivo)){
            if ($fotoOld<>null){
                $array= explode('/', $fotoOld);
                Storage::disk($array[1])->delete($array[2]);
            } 
            $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails()){
              $result['urlImage'] = '{"code":"-3","des_code":"Debe cargar una imagen"}';
            }else{
                $d = new DateTime();
                $now = ($d->format('YmdHms'));
                $nombre_logo = str_random(8);
                $nombre_original=$archivo->getClientOriginalName();
                $extension=$archivo->getClientOriginalExtension();
                $nuevo_nombre = $nombre_logo."_".$now.".".$extension;
                $r1=Storage::disk('imgLogosLocales')->put($nuevo_nombre,  \File::get($archivo) );
                if ($r1){
                    $datos['UrlLogo'] = "/imgLogosLocales/".$nuevo_nombre;
                    $result['urlImage']='{"code":"200","des_code":"'.$nuevo_nombre.'"}';
                }else{
                    $datos['UrlLogo'] = null;
                    $result['urlImage']='{"code":"-3","des_code":"Ocurrio un erro al cargar la imagen"}';
                }
            }    
        }else{
            $datos['UrlLogo'] = null;
            $result['urlImage']='{"code":"200","des_code":""}';
        }
        $result['f_registro'] = $model->regLocal($datos);
        $result['v_locales'] = $model->listLocal();
        return $result;
    }

    //Activar / desactivar local
    protected function postLocalactivo (Request $request){
        $datos = $request->all();
        $model= new Local();
        $empresa = Local::find($datos['IdLocal']);
        $result['activar'] = $model->activarLocal($empresa);
        $result['v_locales'] = $model->listLocal();
        return $result;
    }

    // Ver detalles de los locales
    protected function postLocaldetalle (Request $request){
        $datos = $request->all();
        $model= new Local();
        $result['v_detalles'] = $model->getOneDetalle($datos['IdLocal']);
        $result['v_bodegas'] = $model->bodegasLocal($datos['IdLocal']);
        $result['v_bodegas_local'] = $model->bodegasPrincipalLocal($datos['IdLocal']);
        return $result;
    }

}
