<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EstandarController;
use App\Http\Controllers\Api\PlanController;

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
    #Route::put('plan/{id}',[PlanController::class,'updatePlan']);

    



});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
