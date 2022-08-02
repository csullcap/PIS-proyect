<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fuentes;
use Illuminate\Http\Request;

class FuentesController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $fuente = new Fuentes();
        $fuente->estandar_id = $request->estandar_id;
        $fuente->descripcion = $request->descripcion;
        $fuente->save();
        return response()([
            "status" => 1,
            "message" => "Fuente creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $fuente = Fuentes::find($request->id);
        $fuente->descripcion = $request->descripcion;
        $fuente->save();
        return response([
            "status" => 1,
            "message" => "fuente actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(Fuentes::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $plan = Fuentes::where(["id"=>$id,"id_user"=>$id_user])->first();
              $plan->delete();
              return response([
                  "status" => 1,
                  "message" => "!Fuente eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro la fuente o no esta autorizado",
            ],404);
        }
    }
}
