<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MaquinaController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::controller(MaquinaController::class)->group(function (){
    Route::get('/maquinas','index');
    Route::post('/maquina','store');
    Route::get('/maquina/{id}','show');
    Route::put('/maquina/{id}','update');
    Route::delete('/maquina/{id}','destroy');

});