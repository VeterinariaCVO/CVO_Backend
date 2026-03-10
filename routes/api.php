<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//crear user
Route::post('/users', [UserController::class, 'create']);
//editar user
Route::put('/users/{id}', [UserController::class,'update']);
//eliminar user
Route::delete('/users/{id}', [UserController::class,'destroy']);

// LOGIN Y REGISTER
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);


// RUTA SOLO ADMIN
Route::middleware(['auth:sanctum','role:1'])->get('/admin', function () {
    return response()->json([
        'message' => 'Bienvenido admin'
    ]);
});


// RUTA SOLO EMPLEADO
Route::middleware(['auth:sanctum','role:2'])->get('/empleado', function () {
    return response()->json([
        'message' => 'Bienvenido empleado'
    ]);
});


// RUTA SOLO CLIENTE
Route::middleware(['auth:sanctum','role:3'])->get('/cliente', function () {
    return response()->json([
        'message' => 'Bienvenido cliente'
    ]);
});


// LOGOUT (cualquiera logueado)
Route::middleware('auth:sanctum')->post('/logout', [ApiAuthController::class, 'logout']);