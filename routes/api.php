<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingDayController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('working-days', WorkingDayController::class);
    Route::apiResource('time-slots', TimeSlotController::class);
    Route::apiResource('appointments', AppointmentController::class);
});
