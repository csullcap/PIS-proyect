<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EstandarController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\AccionesMejorasController;
use App\Http\Controllers\Api\CausasRaicesController;
use App\Http\Controllers\Api\FuentesController;
use App\Http\Controllers\Api\ObservacionesController;
use App\Http\Controllers\Api\ProblemasOportunidadesController;
use App\Http\Controllers\Api\RecursosController;
use App\Http\Controllers\Api\MetasController;
use App\Http\Controllers\Api\FuentesValoresController;
use App\Http\Controllers\Api\ResponsablesValoresController;
use App\Http\Controllers\Api\ResponsablesController;
use App\Http\Controllers\Api\EstadosValoresController;
use App\Http\Controllers\Api\EvidenciasController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NarrativasController;


Route::post('login', [UserController::class, 'login'])->name('login');

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);


//Responsables Valores
Route::get('responsables', [ResponsablesValoresController::class, 'listResponsablesValores']);
//fuentes Valores
Route::get('fuentes', [FuentesValoresController::class, 'listFuentesValores']);
//Estados valores
Route::get('estados', [EstadosValoresController::class, 'listEstadosValores']);
//Estandares  valores
Route::get('estandares', [EstandarController::class, 'listEstandarValores']);


//CAMBIAR ESTO
//Route::get('user', [UserController::class, 'listUser']);
Route::get('user', [UserController::class, 'listUserHabilitados']);

/* Route::get('plan/pdf/{id}', [PlanController::class, 'pdfPlan'])->where('id', '[0-9]+'); */

Route::middleware("auth:sanctum")->group(function () {
    //rutas auth
    Route::get('user-profile', [UserController::class, 'userProfile']);
	Route::get('update', [UserController::class, 'updateRoleEstado']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('register', [UserController::class, 'register']);

    //rutas estandar
    Route::post('estandar', [EstandarController::class, 'createEstandar']);
    Route::get('estandar', [EstandarController::class, 'listEstandar']);
    Route::get('estandar/{id}', [EstandarController::class, 'showEstandar'])->where('id', '[0-9]+');
    Route::put('estandar/{id}',  [EstandarController::class, 'updateEstandar'])->where('id', '[0-9]+');
    Route::delete('estandar/{id}', [EstandarController::class, 'deleteEstandar'])->where('id', '[0-9]+');

    //rutas plan
    Route::post('plan', [PlanController::class, 'createPlan']);
    Route::get('plan', [PlanController::class, 'listPlan']);
    Route::get('plan/{id}', [PlanController::class, 'showPlan'])->where('id', '[0-9]+');
    Route::delete('plan/{id}', [PlanController::class, 'deletePlan'])->where('id', '[0-9]+');
    Route::put('plan/{id}', [PlanController::class, 'update'])->where('id', '[0-9]+');
    Route::get('plans/user', [PlanController::class, 'listPlanUser']);
    Route::post('plan/asignar', [PlanController::class, 'assignPlan']);
    //Route::put('plan',[PlanController::class,'updatePlan']);



    //rutas metas
    Route::post('meta', [MetasController::class, 'create']);
    Route::put('meta', [MetasController::class, 'update']);
    Route::delete('meta/{id}', [MetasController::class, 'delete'])->where('id', '[0-9]+');

    //rutas accionesmejoras
    Route::post('accionmejora', [AccionesMejorasController::class, 'create']);
    Route::put('accionmejora', [AccionesMejorasController::class, 'update']);
    Route::delete('accionmejora/{id}', [AccionesMejorasController::class, 'delete'])->where('id', '[0-9]+');

    //rutas fuentes
    Route::post('fuente', [FuentesController::class, 'create']);
    Route::put('fuente', [FuentesController::class, 'update']);
    Route::delete('fuente/{id}', [FuentesController::class, 'delete'])->where('id', '[0-9]+');

    //rutas observaciones
    Route::post('observacion', [ObservacionesController::class, 'create']);
    Route::put('observacion', [ObservacionesController::class, 'update']);
    Route::delete('observacion/{id}', [ObservacionesController::class, 'delete'])->where('id', '[0-9]+');

    //rutas problemas
    Route::post('problema', [ProblemasOportunidadesController::class, 'create']);
    Route::put('problema', [ProblemasOportunidadesController::class, 'update']);
    Route::delete('problema/{id}', [ProblemasOportunidadesController::class, 'delete'])->where('id', '[0-9]+');

    //rutas recursos
    Route::post('recurso', [RecursosController::class, 'create']);
    Route::put('recurso', [RecursosController::class, 'update']);
    Route::delete('recurso/{id}', [RecursosController::class, 'delete'])->where('id', '[0-9]+');

    //rutas casuasraiz
    Route::post('causa', [CausasRaicesController::class, 'create']);
    Route::put('causa', [CausasRaicesController::class, 'update']);
    Route::delete('causa/{id}', [CausasRaicesController::class, 'delete'])->where('id', '[0-9]+');

    //ruta responsables
    Route::post('responsable', [ResponsablesController::class, 'create']);
    Route::put('responsable', [ResponsablesController::class, 'update']);
    Route::delete('responsable/{id}', [ResponsablesController::class, 'delete'])->where('id', '[0-9]+');

    //ruta evidencias
    Route::post('evidencia', [EvidenciasController::class, 'create']);
    Route::get('evidencia/download/{id}', [EvidenciasController::class, 'download'])->where('id', '[0-9]+');
    Route::get('evidencia/{id}', [EvidenciasController::class, 'show'])->where('id', '[0-9]+');
    Route::put('evidencia', [EvidenciasController::class, 'update']);
    Route::delete('evidencia/{id}', [EvidenciasController::class, 'delete'])->where('id', '[0-9]+');

    //ruta narrativas
    Route::post('narrativa', [NarrativasController::class, 'create']);
    Route::get('narrativa/{id}', [NarrativasController::class, 'show'])->where('id', '[0-9]+');
    Route::put('narrativa', [NarrativasController::class, 'update']);
    Route::delete('narrativa/{id}', [NarrativasController::class, 'delete'])->where('id', '[0-9]+');
    Route::get('narrativa', [NarrativasController::class, 'listNarrativas']);
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
