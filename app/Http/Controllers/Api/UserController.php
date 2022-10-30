<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estandar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
			'rol'=> 'required|numeric|min:1|max:2'
        ]);
        $userAuth = auth()->user()->roles[0]->name;
        if ($userAuth == "Admin") {
            $user = new User();
            $user->name = "null";
            $user->lastname = "null";
            $user->email = $request->email;
            $user->password = "null";
			$user->estado = true;
            $user->save();
            $user->roles()->attach($request->rol);
            return response()->json([
                'message' => 'Correo registrado exitosamente',
                'userAuth' => $user,
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "No eres administrador: Correo no registrado",
            ], 404);
        }
    }

    public function login(Request $request)
    {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", "=", $request->email)->where("estado",true)->first();

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "message" => "Usuario logueado",
                    "access_token" => $token,
                    "nombre" => $user->name,
                    "apellido" => $user->lastname,
                ]);
            } else {
                return response()->json([
                    "message" => "La password es incorrecta",
                ], 404);
            }
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Usuario no registrado o deshabilitado",
            ], 404);
        }
    }

    public function userProfile()
    {
        return response()->json([
            "status" => 0,
            "message" => "Perfil de usuario",
            "data" => auth()->user(),
        ]);
    }

	public function listUser(){
		$users = User::all();
		foreach ($users as $user) {
			$user->rol=User::find($user->id)->roles[0]->name;
		}
        return response([
            "status" => 1,
            "msg" => "!Lista de usuarios",
            "data" => $users,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "Sesion cerrada"
        ]);
    }
	public function updateRoleEstado(Request $request){
		$request->validate([
			"id"=>"exists:users",
            "role" => "present|nullable|numeric|min:1|max:2",
            "estado" => "present|nullable|boolean"
        ]);
		if(auth()->user()->isAdmin()){
			$user = User::find($request->id);
			$user->update(['estado' =>$request->estado]);
			$user->roles()->sync([$request->role]);
			return response([
	            "status" => 1,
	            "msg" => "!Update user",
	            "data" => $user,
	        ]);
		}
		else{
			return response()->json([
				"status" => 0,
				"message" => "No eres administrador",
			], 404);
		}
	}
}
