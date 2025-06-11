<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugares;

class LugaresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lugares=Lugares::all();
        return view('lugares.index',compact('lugares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos=[
            'nombre'=> $request->nombre,
            'descripcion'=> $request->descripcion,
            'categoria'=> $request->categoria,
            'imagen'=> $request->imagen,
            'latitud'=> $request->latitud,
            'longitud'=> $request->longitud
        ];
        Cliente::create($datos);
         // Pasar mensaje a la vista con nombre 'message'
        return redirect()->route('clientes.index')->with('message', 'Cliente creado exitosamente');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
