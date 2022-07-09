<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EstandarController;

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

    /*Route::controller(EstandarController::class)->group(function(){
        Route::post('estandar/create', 'createEstandar');
        Route::get('estandar/list', 'listEstandar');
        Route::get('estandar/{id}', 'showEstandar');
        Route::put('estandar/update/{id}', 'updateEstandar');
        Route::delete('estandar/delete/{id}', 'deleteEstandar');
    });*/
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
