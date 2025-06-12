<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LugaresController;

Route::get('/', function () {
    return redirect()->route('Lugares.index');
});

// Rutas para el CRUD de lugares
Route::resource('Lugares', LugaresController::class);

// Ruta para el mapa
Route::get('/Lugares/mapa', [LugaresController::class, 'mapa'])->name('Lugares.mapa');

// Ruta para el filtrado AJAX
Route::get('/Lugares/filtrar', [LugaresController::class, 'filtrar'])->name('Lugares.filtrar');