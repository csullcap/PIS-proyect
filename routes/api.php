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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware("auth:sanctum")->group (function(){
    //rutas auth
    Route::get('user-profile', [UserController::class,'userProfile']);
    Route::get('logout', [UserController::class, 'logout']);

    //rutas estandar
    Route::post('estandar', [EstandarController::class,'createEstandar']);
    Route::get('estandar', [EstandarController::class,'listEstandar']);
    Route::get('estandar/{id}', [EstandarController::class,'showEstandar']);
    Route::put('estandar/{id}',  [EstandarController::class,'updateEstandar']);
    Route::delete('estandar/{id}', [EstandarController::class,'deleteEstandar']);

    //rutas plan
    Route::post('plan',[PlanController::class,'createPlan']);
    Route::get('plan',[PlanController::class,'listPlan']);
    Route::get('plan/{id}',[PlanController::class,'showPlan']);
    Route::delete('plan/{id}',[PlanController::class,'deletePlan']);
    Route::put('plan/{id}',[PlanController::class,'updatePlan']);

    //rutas metas
    Route::post('meta',[MetasController::class,'create']);
    Route::put('meta',[MetasController::class,'update']);
    Route::delete('meta/{id}',[MetasController::class,'delete']);

    //rutas accionesmejoras
    Route::post('accionmejora',[AccionesMejorasController::class,'create']);
    Route::put('accionmejora',[AccionesMejorasController::class,'update']);
    Route::delete('accionmejora/{id}',[AccionesMejorasController::class,'delete']);

    //rutas fuentes
    Route::post('fuente',[FuentesController::class,'create']);
    Route::put('fuente',[FuentesController::class,'update']);
    Route::delete('fuente/{id}',[FuentesController::class,'delete']);

    //rutas observaciones
    Route::post('observacion',[ObservacionesController::class,'create']);
    Route::put('observacion',[ObservacionesController::class,'update']);
    Route::delete('observacion/{id}',[ObservacionesController::class,'delete']);

    //rutas problemas
    Route::post('problema',[ProblemasOportunidadesController::class,'create']);
    Route::put('problema',[ProblemasOportunidadesController::class,'update']);
    Route::delete('problema/{id}',[ProblemasOportunidadesController::class,'delete']);

    //rutas recursos
    Route::post('recurso',[RecursosController::class,'create']);
    Route::put('recurso',[RecursosController::class,'update']);
    Route::delete('recurso/{id}',[RecursosController::class,'delete']);
    
    //rutas casuasraiz
    Route::post('causa',[CausasRaicesController::class,'create']);
    Route::put('causa',[CausasRaicesController::class,'update']);
    Route::delete('causa/{id}',[CausasRaicesController::class,'delete']);



});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
