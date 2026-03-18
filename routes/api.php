<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//crear user
Route::post('/users', [UserController::class, 'create']);
Route::put('/users/{id}', [UserController::class,'update']);
Route::delete('/users/{id}', [UserController::class,'destroy']);


// LOGIN Y REGISTER
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);


// RUTA SOLO ADMIN
Route::middleware(['auth:sanctum','role:1'])->group(function () {
    Route::get('/admin', function () {
        return response()->json(['message' => 'Bienvenido admin']);
    });
    Route::post('/admin/users', [UserController::class, 'create']);
    Route::get('/admin/users', [UserController::class, 'index']);
});

// RUTA SOLO EMPLEADO
Route::middleware(['auth:sanctum','role:2'])->get('/empleado', function () {
    return response()->json([
        'message' => 'Bienvenido empleado'
    ]);
});


// RUTAS PERFIL EMPLEADO
Route::middleware(['auth:sanctum','role:2'])->group(function () {

    Route::get('/empleado/profile', [EmpleadoController::class,'profile']);

    Route::put('/empleado/profile', [EmpleadoController::class,'updateProfile']);

});


// RUTA SOLO CLIENTE
Route::middleware(['auth:sanctum','role:3'])->get('/cliente', function () {
    return response()->json([
        'message' => 'Bienvenido cliente'
    ]);
});


// LOGOUT
Route::middleware('auth:sanctum')->post('/logout', [ApiAuthController::class, 'logout']);
