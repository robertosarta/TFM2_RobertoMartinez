<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/api/documentation')); //Dirige a la documentacion de la API
