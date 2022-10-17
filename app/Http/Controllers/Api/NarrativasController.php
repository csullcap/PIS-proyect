<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estandar;
use App\Models\Narrativa;
//edita solo contenido
//eliminar
// Cabecera endopoint unico
class NarrativasController extends Controller{

	public function create(Request $request){
		$request->validate([
            "id_estandar"=> "required|integer",
            "semestre"=> "required",
			"contenido"=> "required",
        ]);
		if(Estandar::where("id",$request->id_estandar)->exists()){
			$narrativa = new Narrativa();
			$narrativa->id_estandar = $request->id_estandar;
			$narrativa->semestre = $request->semestre;
			$narrativa->contenido = $request->contenido;
			$narrativa->save();
            return response([
                "status" => 1,
                "msg" => "!Narrativa creada exitosamente",
                "data" => $narrativa,
            ]);
        }
        else{
          return response([
              "status" => 0,
              "msg" => "!No se encontro el estandar",
          ],404);
        }
	}
	public function update(Request $request){
		$request->validate([
			"id"=> "required",
			"contenido"=> "required",
        ]);
		if(Narrativa::where("id",$request->id)->exists()){
			$narrativa = Narrativa::find($request->id);
			$narrativa -> update([
				"contenido" => $request->contenido,
			]);
			return response()->json($narrativa, 200);
		}
		else{
			return response([
                "status" => 0,
                "message" => "!No se encontro la narrativa",
            ],404);
		}
	}
	public function delete($id){
		if(Narrativa::where("id",$id)->exists()){
			$narrativa = Narrativa::find($id);
			$narrativa ->delete();
			return response([
				"status" => 1,
				"message" => "!Narrativa eliminada",
			]);
		}
		else{
			return response([
                "status" => 0,
                "message" => "!No se encontro la narrativa",
            ],404);
		}
    }
	public function show($id){
		if(Narrativa::where("id",$id)->exists()){
            $narrativa = Narrativa::find($id);
            return response([
                "status" => 1,
                "message" => "!Narrativa encontrada",
                "data" => $narrativa,
            ]);
        }
        else{
          return response([
              "status" => 0,
              "message" => "!No se encontro la narrativa",
          ],404);
        }
	}
	public function listNarrativas(){
        $narrativas = Narrativas::all();
        return response([
            "status" => 1,
            "msg" => "!Lista de Narrativas",
            "data" => $narrativas,
        ]);
    }
}
