<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
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
            "nombre"=>"present|max:255",
       /*      "codigo"=> "required|unique_with:plans,id_estandar|max:11", */  
            'codigo' => [
                'required', 
                Rule::unique('plans', 'codigo')->where(function ($query) use ($request) {
                    return $query->where('id_estandar', $request->estandar_id);
                }),
            ],
            "fuentes"=>"present",
            "fuentes.*.descripcion"=> "required",
            "problemas_oportunidades"=>"present",
            "problemas_oportunidades.*.descripcion"=> "required",
            "causas_raices"=>"present",
            "causas_raices.*.descripcion"=> "required", 
            "oportunidad_plan"=>"present|max:255",
            "acciones_mejoras"=>"present",
            "acciones_mejoras.*.descripcion"=> "required",
            "semestre_ejecucion"=>"present|max:8", //aaaa-A/B/C/AB
            "duracion"=> "present|integer",
            "recursos"=>"present",
            "recursos.*.descripcion"=> "required", 
            "metas"=>"present",
            "metas.*.descripcion"=> "required", 
            "responsables"=>"present",
            "responsables.*.nombre"=> "required", 
            "observaciones"=>"present",
            "observaciones.*.descripcion"=> "required", 
            "estado"=> "present|max:30",
            /*"evidencias_planes_mejoras"=>"required",
            "evidencias_planes_mejoras.*.codigo"=> "required",
            "evidencias_planes_mejoras.*.denominacion"=> "required",
            "evidencias_planes_mejoras.*.encargado_id"=> "required",
            "evidencias_planes_mejoras*.adjunto"=> "required",*/
            "evaluacion_eficacia"=> "present|boolean",
            "avance"=> "present|integer"
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
            $fuente_aux = new Fuentes();
            $fuente_aux->descripcion = $fuente["descripcion"];
            $fuente_aux->id_plan = $id_plan;
            $fuente_aux->save();
        }

        foreach($request->problemas_oportunidades as $problema){
            $problema_oportunidad_aux = new ProblemasOportunidades();
            $problema_oportunidad_aux->descripcion = $problema["descripcion"];
            $problema_oportunidad_aux->id_plan = $id_plan;
            $problema_oportunidad_aux->save();
        }

        foreach($request->causas_raices as $causa){
            $causa_raiz_aux = new CausasRaices();
            $causa_raiz_aux->descripcion = $causa["descripcion"];
            $causa_raiz_aux->id_plan = $id_plan;
            $causa_raiz_aux->save();
        }

        foreach($request->acciones_mejoras as $accion){
            $accion_mejora_aux = new AccionesMejoras();
            $accion_mejora_aux->descripcion = $accion["descripcion"];
            $accion_mejora_aux->id_plan = $id_plan;
            $accion_mejora_aux->save();
        }

        foreach($request->recursos as $recurso){
            $recurso_aux = new Recursos();
            $recurso_aux->descripcion = $recurso["descripcion"];
            $recurso_aux->id_plan = $id_plan;
            $recurso_aux->save();
        }

        foreach($request->metas as $meta){
            $meta_aux = new Metas();
            $meta_aux->descripcion = $meta["descripcion"];
            $meta_aux->id_plan = $id_plan;
            $meta_aux->save();
        }

        foreach($request->observaciones as $observacion){
            $observacion_aux = new Observaciones();
            $observacion_aux->descripcion = $observacion["descripcion"];
            $observacion_aux->id_plan = $id_plan;
            $observacion_aux->save();
        }

        foreach($request->responsables as $responsable){
            $responsable_aux = new Responsables();
            $responsable_aux ->nombre = $responsable["nombre"];
            $responsable_aux ->id_plan = $id_plan;
            $responsable_aux ->save();
        }
        /*
        $evidencias_planes_mejoras = new Evidencias();   Falta completar
        */

        return response([
            "status" => 1,
            "message" => "!Plan de mejora creado exitosamente",
        ]);
    }

    //falta funcion filtrar por estandares

    public function listPlan(){
        $id_user = auth()->user()->id;

        $planAll = plan::select('plans.id','plans.nombre', 'plans.codigo','plans.avance','plans.estado','plans.id_user','estandars.name as estandar_name','users.name as user_name')
                ->join('estandars', 'plans.id_estandar', '=', 'estandars.id')
                ->join('users', 'plans.id_user', '=', 'users.id')
                ->orderBy('plans.id','asc')
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

	public function updatePlan(Request $request){
        $request->validate([
            "id"=> "required|integer",
            "nombre"=> "required|max:255",
            "oportunidad_plan"=> "required|max:255",
            "semestre_ejecucion"=> "required|max:8",
            "duracion"=> "required|integer",
            "estado"=> "required|max:30",
            "evaluacion_eficacia"=> "required|boolean",
            "avance"=> "required|integer",
        ]);
        $id = $request->id;
        $id_user = auth()->user()->id;
        if(plan::where(["id_user"=>$id_user,"id"=>$id])->exists()){
            $plan = plan::find($id);
            $plan->nombre = $request->nombre;
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
