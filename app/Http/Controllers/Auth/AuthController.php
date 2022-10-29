<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function register(){
        return view('auth.register');
    }

    public function login(){
        
        if(!Auth::guest()){
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function registerVerify(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password'  => 'required|min:4',
            'repeatPassword'  => 'required|same:password'
        ],[
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'Formato de email no valido', 
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es requerido',
            'password.min' => 'La contraseña debe ser mayor a 4 caracteres',
            'repeatPassword.required' => 'Repetir contraseña es requerido',
            'repeatPassword.same' => 'Las contraseñan no son iguales',
        ]);

        User::create([
            'name' => $request->name,
            'rol'  => (!empty($request->rol))?$request->rol:'Consultor',
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success','Usuario registrado correctamente');
    }
    
    public function loginVerify(Request $request){
        $request->validate([ 
            'email' => 'required|email',
            'password'  => 'required|min:4'
        ],[ 
            'email.required' => 'El email es requerido', 
            'email.email' => 'Formato de email no valido', 
            'password.required' => 'La contraseña es requerido',
            'password.min' => 'La contraseña debe ser mayor a 4 caracteres', 
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['invalid_credentials' => 'Usuario o contraseña no valida'])->withInput();
    }

    public function signOut(){
        Auth::logout();
        return redirect()->route('login')->with('success','sesión cerrada correctamente');
    }

    public function changePasswordLogin(Request $request){        

        $User = User::find(auth()->user()->id); 
        $User->password = bcrypt($request->datos['password']);        
        $User->save();

        return array("success"=>true,"data"=> 'Contraseña actualizada');  

    }

}
