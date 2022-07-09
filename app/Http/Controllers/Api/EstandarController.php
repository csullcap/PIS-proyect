<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estandar;
use Illuminate\Support\Facades\DB;

class EstandarController extends Controller
{
    public function createEstandar(Request $request){
        $request->validate([
            "name"=>"required",
        ]);
        $id_user = auth()->user()->id;
        $estandar = new Estandar();
        $estandar->id_user = $id_user;
        $estandar->name = $request->name;
        $estandar->save();
        return response([
            "status" => 1,
            "msg" => "!Estandar creado exitosamente",
        ]);
    }

    public function listEstandar(){
        $estandares = Estandar::all();
        return response([
            "status" => 1,
            "msg" => "!Lista de Estandares",
            "data" => $estandares,
        ]);
    }

    public function showEstandar($id){
        if(Estandar::where("id",$id)->exists()){
            $estandar = Estandar::find($id);
            return response([
                "status" => 1,
                "msg" => "!Estandar",
                "data" => $estandar,
            ]);
        }
        else{
          return response([
              "status" => 0,
              "msg" => "!No se encontro el estandar",
          ],404);
        }

    }

    public function updateEstandar(Request $request, $id){
        $id_user = auth()->user()->id;
        if(Estandar::where(["id_user"=>$id_user,"id"=>$id])->exists()){
            $estandar = Estandar::find($id);
            $estandar->name = isset($request->name) ? $request->name : $estandar->title;
            $estandar->save();
            return response([
                "status" => 1,
                "msg" => "!Estandar actualizado",
                "data" => $estandar,
            ]);
        }
        else{
            return response([
                "status" => 0,
                "msg" => "!No se encontro el estandar o no esta autorizado",
            ],404);
        }

    }

    public function deleteEstandar($id){
        $id_user = auth()->user()->id;
        if(Estandar::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $estandar = Estandar::where(["id"=>$id,"id_user"=>$id_user])->first();
              $estandar->delete();
              return response([
                  "status" => 1,
                  "msg" => "!Estandar eliminado",
              ]);
        }
        else{
            return response([
                "status" => 0,
                "msg" => "!No se encontro el estandar o no esta autorizado",
            ],404);
        }
    }
}
