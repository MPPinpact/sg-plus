<?php

namespace App\Http\Controllers\Auth;

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

// Modelo
use App\Models\Usuario;
// use App\Models\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Pantalla para seleccionar un perfil despues de iniciar sesion
    protected function getAccesos(Request $request){
        //log::info("-->getAccesos();");
        $model= new Usuario();

        if ( $request->session()->has('localUsuario') and $request->session()->has('perfilUsuario') ) {
            return View::make('accesos.accesos');

        }else{
            Session::forget('localUsuario');
            Session::forget('perfilUsuario');
            Session::forget('localUsuario');
            Session::forget('perfilUsuario');

            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('/');
        }

        
        
    }

    // Cargar el perfil escogido
    protected function postAccesos(Request $request){
        //log::info("-->postAccesos();");
        
        $datos = $request->all();
        $model= new Usuario();

        //console.log$datos);

        if (count($datos)>0){
            $result = $model->mostrarPanel($datos['IdPerfil'], $datos['IdLocal']);
        }else{
            $result = '{"code":"500","des_code":"Haga doble click sobre la fila deseada"}';
        }

        return $result;
    }

	protected function postBuscarUsuario(Request $request){
        $datos = $request->all();
        $model= new Usuario();
		
		//console.log$datos);
		
		
        $result['v_usuario'] = $model->getBuscarUsuario($datos['IdUsuario']);
        $result['v_locales'] = $model->getBuscarLocales($datos['IdUsuario']);
        return $result;
    }
	
    //Pantalla de registro de usuario
    protected function getUsuarios(){
        $p = Session::get('perfiles');
        $model= new Usuario();
		
        $data['v_usuarios'] = $model->listUsuario();
        $data['v_perfiles'] = $model->listPerfiles();
        $data['v_estados'] = $model->listEstados();
        $result["perfil"] = $p["idPerfil"];
        $data['v_perfil']=json_encode($result);
        //return View::make('usuarios.usuarios',$data);
		return View::make('usuarios.newUsuarios',$data);
    }

    // Registrar un nuevo usuario o actualizar datos (Administrador)
    protected function postUsuarios(Request $request){
        $p = Session::get('perfiles');
        $datos = $request->all();
        $datos['idEmpresa']=0; 
        // caso Administrador registra Usuario
        if ($p['idPerfil']==1){$datos['caso']=1;}
        // caso Cliente registra Usuario cliente
        if ($p['idPerfil']==2){$datos['caso']=2;}
        // Todos los datos del usuario loggeado
        // $user = Auth::user();
        // El id del usuario logeado
        // $datos['idLoggeo'] = Auth::id();
        $model= new Usuario();
        $result['f_registro'] = $model->regUsuario($datos);
        $result['v_usuarios'] = $model->listUsuario();
        return $result;
    }

    // Pantalla de cambio de contraseña por el usario
    protected function getPassword (){
        $data['title'] = 'Cambio de password';
        $idUser = Auth::id();
        return View::make('auth.passwords.cambioPassword',$data);
    }

    // Cambiar la contraseña por el usuario actual
    protected function postPassword (Request $request){
        $datos = $request->all();
        $datos['idUser'] = Auth::id();
        $model= new Usuario();
        $result= $model->cambiarClave($datos);
        return $result;
    }

    // Pantalla de actualozacion de datos por el mismo usuario
    protected function getPerfil (){
        $data['title'] = 'Mi Perfíl';
        $data['v_datos'] = Auth::user();
        return View::make('perfiles.perfiles',$data);
    }

    // Actualizacion de datos por el usuario actual
    protected function postPerfil (Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $result= $model->actualizarDatos($datos);
        return $result;
    }

    // Cargar los perfiles de un usuario. (Administracion)
    protected function getPerfiles(Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $result['v_perfiles'] = $model->listPerfilesAdministrador($datos['idUser']);
        return $result;
    }

    // Asignar un nuevo perfil a un usuario
    protected function postPerfiles (Request $request){
        $datos = $request->all();
        $model = new Usuario();
        $result = $model->regPerfil($datos);
        return $result;
    }

    // Rgistrar y actualizar foto de perfil
    protected function postCargarfoto (Request $request){
        $idUser=$request->input('idUser');
        $fotoOld = $request->input('usrUrlimage');
        $archivo = $request->file('foto');
        if ($fotoOld<>null){
            $array= explode('/', $fotoOld);
            Storage::disk($array[1])->delete($array[2]);
        } 
        $input  = array('foto' => $archivo);
        $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails()){
          return '{"code":"-2","des_code":"Debe cargar una imagen"}';
        }else{
            $nombre_original=$archivo->getClientOriginalName();
            $extension=$archivo->getClientOriginalExtension();
            $nuevo_nombre="idUser-".$idUser.".".$extension;
            $r1=Storage::disk('imgUsuarios')->put($nuevo_nombre,  \File::get($archivo) );
            $rutadelaimagen="/imgUsuarios/".$nuevo_nombre;
            if ($r1){
                sleep(3); 
                $model= new Usuario();
                $result= $model->actualizarFoto($idUser,$rutadelaimagen);
                return '{"code":"200","des_code":"'.$rutadelaimagen.'"}';
            }else{
                return '{"code":"-3","des_code":"Ocurrio un erro al cargar la imagen"}';
            }
        } 
    }

    // Eliminar foto de perfil
    protected function postEliminarfoto (Request $request){
        $datos = $request->all();
        if ($datos['usrUrlimage']<>null){
            $array= explode('/', $datos['usrUrlimage']);
            Storage::disk($array[1])->delete($array[2]);
        } 
        $model= new Usuario();
        $result=$model->eliminarFoto($datos);
        return $result;
    }

    // Reiniciar contraseña de usuarios (Administrador)
    protected function postReiniciar (Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $usuario = Usuario::find($datos['idUser'] );
        $result = $model->cambiarPassword($usuario);
        return $result;
    }

    // Activar o Desactivar usuarios
    protected function postUsuarioactivo (Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $usuario = Usuario::find($datos['idUser']);
        $result['activar'] = $model->activarUsuario($usuario);
        $result['v_usuarios'] = $model->listUsuario();
        return $result;
    }

    // Activar o Desactivar perfiles
    protected function postPerfilactivo (Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $result['activar'] = $model->activarPerfil($datos);
        $result['v_perfiles'] = $model->listPerfilesAdministrador($datos['IdUser']);
        return $result;
    }

    // Desbloquear cuenta de usuario por maximo de intentos fallídos
    protected function postDesbloquearcuenta (Request $request){
        $datos = $request->all();
        $model= new Usuario();
        $usuario = $model->getUsuario($datos);
        if ($usuario[0]->EstadoBloqueo == 1){
            $result['v_desbloqueo'] = '{"code":"-2","des_code":"Este usuario no se encuentra bloqueado"}';
        }else{
            $result['v_desbloqueo'] = $model->resetIntentosFallidos($datos['idUser']);
            $result['v_usuarios'] = $model->listUsuario();
        }
        return $result;
    }
    
}