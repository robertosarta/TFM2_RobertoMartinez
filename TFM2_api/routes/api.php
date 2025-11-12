<?php

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\SubcategoryApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']); //LOGIN PUBLICO
Route::post('/register', [AuthController::class, 'register']); //REGISTRO PUBLICO
Route::get('/users/{id}', [UserApiController::class, 'show']); //VER USUARIO PUBLICO
Route::get('/categories', [CategoryApiController::class, 'index']);//INDICE CATEGORIAS PUBLICO
Route::get('/services', [ServiceApiController::class, 'index']);//INDICE SERVICIOS PUBLICO
Route::get('/services/{id}', [ServiceApiController::class, 'show']);//VER SERVICIO PUBLICO
Route::get('/subcategories', [SubcategoryApiController::class, 'index']);//INDICE SUBCATEGORIAS PUBLICO
Route::get('/subcategories/{id}', [SubcategoryApiController::class, 'show']);//VER SUBCATEGORIAS PUBLICO


Route::middleware('auth:sanctum')->group(function() {
    //LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);
    //CRUD USUARIOS
    Route::apiResource('users', UserApiController::class)->only(['index', 'store', 'update', 'destroy']);
    //CRUD CATEGORIAS
    Route::apiResource('categories', CategoryApiController::class)->only(['store', 'update', 'destroy']);
    //CRUD SERVICIOS
    Route::apiResource('services', ServiceApiController::class)->only(['store', 'update', 'destroy']);
    //CRUD SUBCATEGORIAS
    Route::apiResource('subcategories', SubcategoryApiController::class)->only(['store', 'update', 'destroy']);
});


//php artisan route:list --path=api
