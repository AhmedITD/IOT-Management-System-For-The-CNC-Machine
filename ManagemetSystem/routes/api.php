<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gcodeController;
use App\Http\Controllers\apiController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/apiLogin', [apiController::class, 'apiLogin'])->middleware('apiAuth');

Route::post('/gcodes/{gcode}', [apiController::class, 'apiPost'])->name(name: 'apiPost')->middleware('apiAuth')->middleware('auth:sanctum');
Route::get('/gcodes', [apiController::class, 'api'])->name(name: 'api')->middleware('apiAuth')->middleware('auth:sanctum');