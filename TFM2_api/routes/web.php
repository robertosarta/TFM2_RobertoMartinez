<?php

// use App\Http\Controllers\Api\UserApiController;
// use App\Http\Controllers\Api\CategoryApiController;
// use Illuminate\Support\Facades\Route;


// Route::post('/users', [UserApiController::class, 'store']); //REGISTRO PUBLICO
// Route::get('/users/{id}', [UserApiController::class, 'show']); //VER USUARIO PUBLICO
// Route::get('/categories', [CategoryApiController::class, 'index']);//INDICE CATEGORIAS PUBLICO


// //TOKEN ADMIN;    1|inRwhbiNl2dhA1si5PDPFW23gI5aHYMSpgg1AtpG2e8253a1
// Route::middleware('auth:sanctum')->group(function() {
//     //CRUD USUARIOS
//     Route::apiResource('users', UserApiController::class)->only(['index', 'update', 'destroy']);
//     //CRUD CATEGORIAS
//     Route::apiResource('categories', CategoryApiController::class)->only(['store', 'update', 'destroy']);
// });