<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LugaresController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/Lugares/mapa',[LugaresController::class,'mapa']);
//Habilitando acceso al controlador
Route::resource('Lugares',LugaresController::class);


