<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProblemasOportunidades;
use Illuminate\Http\Request;

class ProblemasOportunidadesController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $problema = new ProblemasOportunidades();
        $problema->estandar_id = $request->estandar_id;
        $problema->descripcion = $request->descripcion;
        $problema->save();
        return response()([
            "status" => 1,
            "message" => "problema creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $problema = ProblemasOportunidades::find($request->id);
        $problema->descripcion = $request->descripcion;
        $problema->save();
        return response([
            "status" => 1,
            "message" => "problema actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(ProblemasOportunidades::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $problema = ProblemasOportunidades::where(["id"=>$id,"id_user"=>$id_user])->first();
              $problema->delete();
              return response([
                  "status" => 1,
                  "message" => "problema eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro el problema o no esta autorizado",
            ],404);
        }
    }
}
