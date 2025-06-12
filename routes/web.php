<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LugaresController;

Route::get('/', function () {
    return redirect()->route('Lugares.index');
});

Route::resource('Lugares', LugaresController::class);

Route::get('/Lugares/mapa', [LugaresController::class, 'mapa'])->name('Lugares.mapa');

Route::get('/Lugares/filtrar', [LugaresController::class, 'filtrar'])->name('Lugares.filtrar');