<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\WorkingDayController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\PetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// LOGIN Y REGISTER
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login',    [ApiAuthController::class, 'login']);

// LOGOUT
Route::middleware('auth:sanctum')->post('/logout', [ApiAuthController::class, 'logout']);

// RUTAS ADMIN
Route::middleware(['auth:sanctum', 'role:1'])->group(function () {
    Route::get('/admin/users',         [UserController::class, 'index']);
    Route::post('/admin/users',        [UserController::class, 'create']);
    Route::get('/admin/users/{id}',    [UserController::class, 'show']);
    Route::put('/admin/users/{id}',    [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);

    // Mascotas - admin
    Route::get('/pets',        [PetController::class, 'index']);
    Route::get('/pets/{id}',   [PetController::class, 'show']);
    Route::post('/pets',       [PetController::class, 'store']);
    Route::put('/pets/{id}',   [PetController::class, 'update']);
    Route::delete('/pets/{id}',[PetController::class, 'destroy']);
});

// RUTAS EMPLEADO
Route::middleware(['auth:sanctum', 'role:2'])->group(function () {
    Route::get('/empleado', function () {
        return response()->json(['message' => 'Bienvenido empleado']);
    });
    Route::get('/empleado/profile',  [EmpleadoController::class, 'profile']);
    Route::put('/empleado/profile',  [EmpleadoController::class, 'updateProfile']);

    // Clientes
    Route::get('/empleado/clients',      [UserController::class, 'clients']);
    Route::get('/empleado/clients/{id}', [UserController::class, 'showClient']);

    // Mascotas - empleado
    Route::get('/pets',         [PetController::class, 'index']);
    Route::get('/pets/{id}',    [PetController::class, 'show']);
    Route::post('/pets',        [PetController::class, 'store']);
    Route::put('/pets/{id}',    [PetController::class, 'update']);
    Route::delete('/pets/{id}', [PetController::class, 'destroy']);
});

// RUTAS CLIENTE
Route::middleware(['auth:sanctum', 'role:3'])->group(function () {
    Route::get('/cliente', function () {
        return response()->json(['message' => 'Bienvenido cliente']);
    });
    Route::get('/mis-mascotas',         [PetController::class, 'index']);
    Route::get('/mis-mascotas/{id}',    [PetController::class, 'show']);
    Route::post('/mis-mascotas',        [PetController::class, 'store']);
    Route::put('/mis-mascotas/{id}',    [PetController::class, 'update']);
    Route::delete('/mis-mascotas/{id}', [PetController::class, 'destroy']);
});

// Appointments
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('working-days',  WorkingDayController::class);
    Route::apiResource('time-slots',    TimeSlotController::class);
    Route::apiResource('appointments',  AppointmentController::class);
});