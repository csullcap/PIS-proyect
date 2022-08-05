<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\plan;
use App\Models\AccionesMejoras;
use App\Models\CausasRaices;
use App\Models\Evidencias;
use App\Models\Fuentes;
use App\Models\Metas;
use App\Models\Observaciones;
use App\Models\ProblemasOportunidades;
use App\Models\Recursos;
use App\Models\Responsables;


class PlanController extends Controller{

     // Arreglar el formato de IDs
    public function createPlan(Request $request){
        $request->validate([
            "estandar_id"=> "required|integer",
            "nombre"=>"required|max:255",
            "codigo"=> "required|max:11",
            /*"fuentes"=>"required",
            "fuentes.*.descripcion"=> "required",
            "problemas_oportunidades"=>"required",
            "problemas_oportunidades.*.descripcion"=> "required",
            "causas_raices"=>"required",
            "causas_raices.*.descripcion"=> "required",*/
            "oportunidad_plan"=>"required|max:255",
            /*"acciones_mejoras"=>"required",
            "acciones_mejoras.*.descripcion"=> "required",*/
            "semestre_ejecucion"=>"required|max:7", 
            "duracion"=> "required|integer",
            /*"recursos"=>"required",
            "recursos.*.descripcion"=> "required",
            "metas"=>"required",
            "metas.*.descripcion"=> "required",
            "responsables"=>"required",
            "responsables.*.nombre"=> "required",
            "observaciones"=>"required",
            "observaciones.*.descripcion"=> "required",*/
            "estado"=> "required|max:30",
            /*"evidencias_planes_mejoras"=>"required",
            "evidencias_planes_mejoras.*.codigo"=> "required",
            "evidencias_planes_mejoras.*.denominacion"=> "required",
            "evidencias_planes_mejoras.*.encargado_id"=> "required",
            "evidencias_planes_mejoras.*.adjunto"=> "required",*/
            "evaluacion_eficacia"=> "required|boolean",
            "avance"=> "required|integer",
        ]);

        $id_user = auth()->user()->id;
        $plan = new plan();
        
        $plan->id_user = $id_user;
        $plan->id_estandar = $request->estandar_id;                     //actualizar a estandar_id

        $plan->nombre = $request->nombre;
        $plan->codigo = $request->codigo;
        $plan->oportunidad_plan = $request->oportunidad_plan;
        $plan->semestre_ejecucion = $request->semestre_ejecucion;
        $plan->duracion = $request->duracion;
        $plan->estado = $request->estado;
        $plan->evaluacion_eficacia = $request->evaluacion_eficacia;
        $plan->avance = $request->avance;
        $plan->save();
        
        $id_plan = $plan->id;

        foreach($request->fuentes as $fuente){
            $fuentes_aux = new Fuentes();
            $fuentes_aux->descripcion = $fuente["descripcion"];
            $fuentes_aux->id_plan = $id_plan;
            $fuentes_aux->save();
        }

        foreach($request->problemas_oportunidades as $problema){
            $problemas_oportunidades_aux = new ProblemasOportunidades();
            $problemas_oportunidades_aux->descripcion = $problema["descripcion"];
            $problemas_oportunidades_aux->id_plan = $id_plan;
            $problemas_oportunidades_aux->save();
        }

        foreach($request->causas_raices as $causa){
            $causas_raices_aux = new CausasRaices();
            $causas_raices_aux->descripcion = $causa["descripcion"];
            $causas_raices_aux->id_plan = $id_plan;
            $causas_raices_aux->save();
        }

        foreach($request->acciones_mejoras as $accion){
            $acciones_mejoras_aux = new AccionesMejoras();
            $acciones_mejoras_aux->descripcion = $accion["descripcion"];
            $acciones_mejoras_aux->id_plan = $id_plan;
            $acciones_mejoras_aux->save();
        }

        foreach($request->recursos as $recurso){
            $recursos_aux = new Recursos();
            $recursos_aux->descripcion = $recurso["descripcion"];
            $recursos_aux->id_plan = $id_plan;
            $recursos_aux->save();
        }

        foreach($request->metas as $meta){
            $meta_aux = new Metas();
            $meta_aux->descripcion = $meta["descripcion"];
            $meta_aux->id_plan = $id_plan;
            $meta_aux->save();
        }

        foreach($request->observaciones as $observacion){
            $observaciones_aux = new Observaciones();
            $observaciones_aux->descripcion = $observacion["descripcion"];
            $observaciones_aux->id_plan = $id_plan;
            $observaciones_aux->save();
        }

        /*
        $evidencias_planes_mejoras = new Evidencias();   Falta completar
        $responsables = new Responsables();              Falta completar
        */

        return response([
            "status" => 1,
            "message" => "!Plan de mejora creado exitosamente",
        ]);
    }

    public function listPlan(){
        $id_user = auth()->user()->id;  

        $planAll = plan::select('plans.id','plans.nombre', 'plans.codigo','plans.avance','plans.estado','plans.id_user','estandars.name as estandar_name','users.name as user_name')
                ->join('estandars', 'plans.id_estandar', '=', 'estandars.id')
                ->join('users', 'plans.id_user', '=', 'users.id')
                ->orderBy('id','asc')
                ->get();
                
        foreach($planAll as $plan){   
            $plan->esCreador = ($plan->id_user == $id_user)?true:false;
            unset($plan->id_user);
        }

        return response([
            "status" => 1,
            "message" => "!Lista de planes de mejora",
            "data" => $planAll,
        ]);
    }

    public function updatePlan(Request $request, $id){
        $id_user = auth()->user()->id;
        if(plan::where(["id_user"=>$id_user,"id"=>$id])->exists()){
            $plan = plan::find($id);
            $plan->nombre = $request->nombre;
            $plan->codigo = $request->codigo;
            $plan->oportunidad_plan = $request->oportunidad_plan;
            $plan->semestre_ejecucion = $request->semestre_ejecucion;
            $plan->duracion = $request->duracion;
            $plan->estado = $request->estado;
            $plan->evaluacion_eficacia = $request->evaluacion_eficacia;
            $plan->avance = $request->avance;
            $plan->save();
            return response([
                "status" => 1,
                "message" => "!Plan de mejora actualizado",
                "data" => $plan,
            ]);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro el plan o no esta autorizado",
            ],404);
        }

    }


    public function deletePlan($id){
        $id_user = auth()->user()->id;
        if(plan::where(["id"=>$id,"id_user"=>$id_user])->exists()){
              $plan = plan::where(["id"=>$id,"id_user"=>$id_user])->first();
              $plan->delete();
              return response([
                  "status" => 1,
                  "message" => "!Plan de mejora eliminado",
              ]);
        }
        else{
            return response([
                "status" => 0,
                "message" => "!No se encontro el plan de mejora o no esta autorizado",
            ],404);
        }
    }

    //faltas completar
    public function showPlan($id){
        if(plan::where("id",$id)->exists()){
            $plan = plan::find($id);
            $plan->fuentes = Fuentes::where("id_plan",$id)->get();
            $plan->problemas_oportunidades = ProblemasOportunidades::where("id_plan",$id)->get();
            $plan->causas_raices = CausasRaices::where("id_plan",$id)->get();
            $plan->acciones_mejoras = AccionesMejoras::where("id_plan",$id)->get();
            $plan->recursos = Recursos::where("id_plan",$id)->get();
            $plan->metas = Metas::where("id_plan",$id)->get();
            $plan->observaciones = Observaciones::where("id_plan",$id)->get();
            $plan->evidencias_planes_mejoras = Evidencias::where("id_plan",$id)->get();
            return response([
                "status" => 1,
                "message" => "!Plan de mejora encontrado",
                "data" => $plan,
            ]);
        }
        else{
          return response([
              "status" => 0,
              "message" => "!No se encontro el plan de mejora",
          ],404);
        }
    }
}
