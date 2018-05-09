<?php

namespace Illuminate\Foundation\Auth;
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use Form;
use Lang;
use View;
use Redirect;
use SerializesModels;
use Log;
use Session;

use App\Models\Usuario;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        //log::info("LoginController->login()");
        $data= $request->All();

        if ($data['usrUserName'] && $data['usrPassword']){
            $model= new Usuario();
            $result = $model->verificarUsuario($data);
            //log::info($result);
            
            return $result;  
        }else{
            return '{"code":"-2","des_code":"Debe ingresar valores correctos"}';
        }
    }

    public function logout(Request $request){
        $idUser = Auth::id();
        $model= new Usuario();
        $result = $model->registrarVisita($idUser);

        Session::forget('localUsuario');
        Session::forget('perfilUsuario');
        Session::forget('localesUsuario');
        Session::forget('perfilesUsuario');

        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
