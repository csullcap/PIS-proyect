<?php

namespace App\Http\Controllers;

use App\Models\Metas;
use Illuminate\Http\Request;

class MetasController extends Controller {
    
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $meta = new Metas();
        $meta->estandar_id = $request->estandar_id;
        $meta->descripcion = $request->descripcion;
        $meta->save();
        return response()([
            "status" => 1,
            "message" => "Meta creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $meta = Metas::find($request->id);
        $meta->descripcion = $request->descripcion;
        $meta->save();
        return response([
            "status" => 1,
            "message" => "Meta actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(Metas::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $plan = Metas::where(["id"=>$id,"id_user"=>$id_user])->first();
              $plan->delete();
              return response([
                  "status" => 1,
                  "message" => "!Meta eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro la meta o no esta autorizado",
            ],404);
        }
    }
}
