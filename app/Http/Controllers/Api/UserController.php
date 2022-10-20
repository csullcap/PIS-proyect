<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estandar;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
		$request->validate([
            'email'=>'required|email|unique:users'
        ]);
		$userAuth = auth()->user()->roles[0]->name;
		if($userAuth==="Admin"){
			$user = new User();
	        $user->name = "null";
	        $user->lastname = "null";
	        $user->email = $request->email;
	        $user->password = "null";
	        $user->save();
			$user->roles()->attach(2);
			return response()->json([
	            'message'=>'Correo registrado exitosamente',
				'userAuth'=>$user,
	        ]);
		}
		else{
			return response()->json([
                "status" => 0,
                "message" => "Correo no registrado",
            ], 404);
		}

    }

    public function login(Request $request){

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email","=", $request->email)->first();

        if(isset($user->id) ){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "message" => "Usuario logueado",
                    "access_token" => $token,
                    "nombre" => $user->name,
                    "apellido" => $user->lastname,
                ]);
            }else{
                return response()->json([
                    "message" => "La password es incorrecta",
                ], 404);
            }

        }else{
            return response()->json([
                "status" => 0,
                "message" => "Usuario no registrado",
            ], 404);
        }
    }

    public function userProfile(){
        return response()->json([
            "status" => 0,
            "message" => "Perfil de usuario",
            "data" => auth()->user()
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "message" => "Cierre de Sesión",
        ]);
    }

}
