<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CausasRaices;
use Illuminate\Http\Request;

class CausasRaicesController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $causa = new CausasRaices();
        $causa->estandar_id = $request->estandar_id;
        $causa->descripcion = $request->descripcion;
        $causa->save();
        return response()([
            "status" => 1,
            "message" => "Causa creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $causa = CausasRaices::find($request->id);
        $causa->descripcion = $request->descripcion;
        $causa->save();
        return response([
            "status" => 1,
            "message" => "Causa actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(CausasRaices::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $causa = CausasRaices::where(["id"=>$id,"id_user"=>$id_user])->first();
              $causa->delete();
              return response([
                  "status" => 1,
                  "message" => "!Causa eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro la causa o no esta autorizado",
            ],404);
        }
    }
}
