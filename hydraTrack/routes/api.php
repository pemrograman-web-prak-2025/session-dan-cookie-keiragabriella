<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WaterLogApiController; // Import Controller

// Rute default (bisa dibiarkan)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('water-logs', WaterLogApiController::class);