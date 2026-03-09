<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//crear user
Route::post('/users', [UserController::class, 'create']);
//listasUsaurio
Route::get('clients',[UserController::class,'index']);
Route::put('/clients/{id}', [UserController::class, 'update']);
Route::delete('/clients/{id}', [UserController::class, 'destroy']);

//LOGIN AND REGISTER
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [ApiAuthController::class, 'logout']);


