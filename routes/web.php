<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LugaresController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/lugares/mapa',[LugaresController::class,'mapa']);
//Habilitando acceso al controlador
Route::resource('lugares',LugaresController::class);


