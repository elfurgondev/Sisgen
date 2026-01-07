<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PropertyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::get('/leads', [SalesController::class, 'index']);
    Route::post('/sales', [SalesController::class, 'store']);
    Route::get('/clients/{client}', [SalesController::class, 'show']);

    Route::apiResource('properties', PropertyController::class);
});
