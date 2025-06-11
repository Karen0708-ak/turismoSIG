<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Lugares extends Model
{
    //
    use HasFactory;
    //DEFINIR ATRIBUSTOS 
    protected $fillable=[
    'nombre',
    'descripcion',
    'categoria',
    'imagen',
    'latitud',
    'longitud',
];
}
