<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugares;
use Illuminate\Support\Facades\Storage;

class LugaresController extends Controller
{
    public function index(Request $request)
{
    $query = Lugares::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('nombre', 'like', '%' . $request->search . '%');
    }

    if ($request->has('categoria') && $request->categoria != '') {
        $query->where('categoria', $request->categoria);
    }

    $lugares = $query->paginate(10); // ← Paginación
    $categorias = Lugares::select('categoria')->distinct()->get();

    return view('Lugares.index', compact('lugares', 'categorias'));
}

    public function mapa()
    {
        $lugares = Lugares::all();
        $categorias = Lugares::select('categoria')->distinct()->get();
        return view('Lugares.mapa', compact('lugares', 'categorias'));
    }

    public function create()
    {
        return view('Lugares.nuevo');
    }

    public function store(Request $request)
    {
        // Subir imagen si viene en el request
        $imagenUrl = null;
        if ($request->hasFile('imagen')) {
            $imagenUrl = $request->file('imagen')->store('imagenes', 'public');
        }
        //Capturar valores u almacenarlos en la BDD
        $datos=[
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'imagen' => $imagenUrl,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ];
        Lugares::create($datos);
         // Pasar mensaje a la vista con nombre 'message'
        return redirect()->route('Lugares.index')->with('message', 'Lugar creado
        exitosamente');
    }

    public function show($id)
    {
        $lugar = Lugares::findOrFail($id);
        return view('Lugares.ver', compact('lugar'));
    }

    public function edit($id)
    {
        $lugar = Lugares::findOrFail($id);
        return view('Lugares.editar', compact('lugar'));
    }

    public function update(Request $request, $id)
    {
        $lugar = Lugares::findOrFail($id);

        // Subir nueva imagen si viene en el request
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($lugar->imagen && Storage::exists('public/' . $lugar->imagen)) {
                Storage::delete('public/' . $lugar->imagen);
            }
    
            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
            $lugar->imagen = $imagenPath; // <<---- AQUÍ cambió
        }
        // Datos recibidos para actualizar
        $lugar->nombre = $request->nombre;
        $lugar->descripcion = $request->descripcion;
        $lugar->categoria = $request->categoria;
        $lugar->latitud = $request->latitud;
        $lugar->longitud = $request->longitud;

        $lugar->save();

        // Redirigir con mensaje
        return redirect()->route('Lugares.index')->with('message', 'Lugar actualizado exitosamente');

    }

    public function destroy($id)
    {
        $lugar = Lugares::findOrFail($id);
        
        // Eliminar imagen asociada
        if ($lugar->imagen) {
            $oldImage = str_replace('/storage', 'public', $lugar->imagen);
            Storage::delete($oldImage);
        }
        
        $lugar->delete();
        
        return redirect()->route('Lugares.index')->with('success', 'Lugar eliminado exitosamente');
    }

    public function filtrar(Request $request)
    {
        $categoria = $request->categoria;
        
        if ($categoria == 'todos') {
            $lugares = Lugares::all();
        } else {
            $lugares = Lugares::where('categoria', $categoria)->get();
        }
        
        return response()->json($lugares);
    }
}