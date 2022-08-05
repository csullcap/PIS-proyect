<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Observaciones;
use Illuminate\Http\Request;

class ObservacionesController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "estandar_id"=> "required|integer",
            "descripcion"=> "required",
        ]);
        $observacion = new Observaciones();
        $observacion->estandar_id = $request->estandar_id;
        $observacion->descripcion = $request->descripcion;
        $observacion->save();
        return response()([
            "status" => 1,
            "message" => "Observacion creada exitosamente"
        ]);
    }

    public function update(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "descripcion"=> "required"
        ]);
        $observacion = Observaciones::find($request->id);
        $observacion->descripcion = $request->descripcion;
        $observacion->save();
        return response([
            "status" => 1,
            "message" => "Observacion actualizada exitosamente",
        ]);
    }

    public function delete($id)
    {
        $id_user = auth()->user()->id;
        if(Observaciones::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $observacion = Observaciones::where(["id"=>$id,"id_user"=>$id_user])->first();
              $observacion->delete();
              return response([
                  "status" => 1,
                  "message" => "!Observacion eliminada con éxito!",
              ],200);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro la Observacion o no esta autorizado",
            ],404);
        }
    }
}
