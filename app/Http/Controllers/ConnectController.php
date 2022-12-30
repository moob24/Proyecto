<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App;

class ConnectController extends Controller
{
    public function getLogin(){
        return view('connect.login');
    }

    public function getRegister(){
        return view('connect.register');
    }

    public function postRegister(Request $request){
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'carrera' => 'required',
            'email' => 'required|email|unique:App\User,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
        ];

        $messages = [
            'name.required' => 'Su nombre es requerido.',
            'lastname.required' => 'Su apellido es requerido.',
            'email.required' => 'Su email es requerido.',
            'email.email' => 'El formato de su email no es valido',
            'email.unique' => 'Ya existe el email, intente con otro',
            'password.required' => 'Por favor escriba una contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'cpassword.required' => 'Es necesario confimar la contraseña',
            'cpassword.same' => 'Las contraseñas no coinciden' 

            
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error.')->with( 'typealert' , 'danger');
        else:
            $user = new User;
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));
            $user->carrera = e($request->input('carrera'));
            $user->email = e($request->input('email')); 
            $user->password = Hash::make($request->input('password'));

            if ($user->save()):
                return redirec('/login')->with('message', 'Su usuario se creó exitosamente ')->with('typealert', 'success');
            endif;
        endif;
    }
}
