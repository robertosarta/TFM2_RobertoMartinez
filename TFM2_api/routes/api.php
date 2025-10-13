<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CategoryApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(\Illuminate\Http\Request $request){
        return response()->json($request->user());
    });

    Route::apiResource('users', UserApiController::class)->only(['index','store','destroy','show','update']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});