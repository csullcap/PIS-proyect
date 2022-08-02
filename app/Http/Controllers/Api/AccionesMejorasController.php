<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccionesMejoras;
use Illuminate\Http\Request;

class AccionesMejorasController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $accion = new AccionesMejoras();
        $accion->estandar_id = $request->estandar_id;
        $accion->descripcion = $request->descripcion;
        $accion->save();
        return response()([
            "status" => 1,
            "message" => "accion creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $accion = AccionesMejoras::find($request->id);
        $accion->descripcion = $request->descripcion;
        $accion->save();
        return response([
            "status" => 1,
            "message" => "accion actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(AccionesMejoras::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $plan = AccionesMejoras::where(["id"=>$id,"id_user"=>$id_user])->first();
              $plan->delete();
              return response([
                  "status" => 1,
                  "message" => "!accion eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro la accion o no esta autorizado",
            ],404);
        }
    }
}
