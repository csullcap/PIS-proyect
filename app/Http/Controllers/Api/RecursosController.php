<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recursos;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $recurso = new Recursos();
        $recurso->estandar_id = $request->estandar_id;
        $recurso->descripcion = $request->descripcion;
        $recurso->save();
        return response()([
            "status" => 1,
            "message" => "Recurso creado exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $recurso = Recursos::find($request->id);
        $recurso->descripcion = $request->descripcion;
        $recurso->save();
        return response([
            "status" => 1,
            "message" => "Recurso actualizado exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(Recursos::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $plan = Recursos::where(["id"=>$id,"id_user"=>$id_user])->first();
              $plan->delete();
              return response([
                  "status" => 1,
                  "message" => "!Recurso eliminado con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro el Recurso o no esta autorizado",
            ],404);
        }
    }
}
