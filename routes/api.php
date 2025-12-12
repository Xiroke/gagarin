<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\GagarinController;
use App\Http\Controllers\LunarMissionController;
use App\Http\Controllers\SpaceFlightController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/authorization', [AuthController::class, 'authorization']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/api/gagarin-flight', [GagarinController::class, 'index']);
    Route::get('/flight', [FlightController::class, 'index']);
    Route::get('/lunar-missions', [LunarMissionController::class, 'index']);
    Route::get('/search', [LunarMissionController::class, 'search']);
    Route::post('/lunar-missions', [LunarMissionController::class, 'store']);
    Route::patch('/lunar-missions/{lunar_mission}', [LunarMissionController::class, 'update']);
    Route::delete('/lunar-missions/{lunar_mission}', [LunarMissionController::class, 'destroy']);

    Route::post('/space-flights', [SpaceFlightController::class, 'store']);
    Route::get('/space-flights', [SpaceFlightController::class, 'index']);
    Route::post('/space-flight', [SpaceFlightController::class, 'book']);
});

