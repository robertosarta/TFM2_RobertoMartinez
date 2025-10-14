<?php

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\SubcategoryApiController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'index']);
Route::post('/users', [UserApiController::class, 'store']); //REGISTRO PUBLICO
Route::get('/users/{id}', [UserApiController::class, 'show']); //VER USUARIO PUBLICO
Route::get('/categories', [CategoryApiController::class, 'index']);//INDICE CATEGORIAS PUBLICO
Route::get('/services', [ServiceApiController::class, 'index']);//INDICE SERVICIOS PUBLICO
Route::get('/services/{id}', [ServiceApiController::class, 'show']);//VER SERVICIO PUBLICO
Route::get('/subcategories', [SubcategoryApiController::class, 'index']);//INDICE SUBCATEGORIAS PUBLICO
Route::get('/subcategories/{id}', [SubcategoryApiController::class, 'show']);//VER SUBCATEGORIAS PUBLICO


//TOKEN ADMIN;    1|inRwhbiNl2dhA1si5PDPFW23gI5aHYMSpgg1AtpG2e8253a1
Route::middleware('auth:sanctum')->group(function() {
    //CRUD USUARIOS
    Route::apiResource('users', UserApiController::class)->only(['index', 'update', 'destroy']);
    //CRUD CATEGORIAS
    Route::apiResource('categories', CategoryApiController::class)->only(['store', 'update', 'destroy']);
    //CRUD SERVICIOS
    Route::apiResource('services', ServiceApiController::class)->only(['store', 'update', 'destroy']);
    //CRUD SUBCATEGORIAS
    Route::apiResource('subcategories', SubcategoryApiController::class)->only(['store', 'update', 'destroy']);
});


//2|jVyeJJNkfvRnKeneuSQC4Z17CC67DvglwT2cgh471f9ec552
//php artisan route:list --path=api