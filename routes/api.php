<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// ---------- Auth Routes ----------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ---------- Protected Routes ----------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/customers/app', [CustomerController::class, 'index']);
    Route::post('/customers/store', [CustomerController::class, 'store']);
});

// Route::middleware('auth:sanctum')->get('/customers/app', [CustomerController::class, 'index']);
