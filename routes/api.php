<?php

use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Team API routes
Route::apiResource('teams', TeamController::class);

// Additional team routes
Route::get('teams-active', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Team::active()->ordered()->get(),
        'message' => 'Active teams retrieved successfully'
    ]);
});

// Settings API routes
Route::prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index']);
    Route::get('/flat', [SettingsController::class, 'flat']);
    Route::get('/group/{group}', [SettingsController::class, 'getByGroup']);
    Route::get('/{key}', [SettingsController::class, 'show']);
});
