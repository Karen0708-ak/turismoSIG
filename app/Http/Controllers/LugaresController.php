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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric'
        ]);

        $imagenPath = $request->file('imagen')->store('public/lugares');
        $imagenUrl = Storage::url($imagenPath);

        Lugares::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'imagen' => $imagenUrl,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ]);

        return redirect()->route('Lugares.index')->with('success', 'Lugar creado exitosamente');
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
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ];

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($lugar->imagen) {
                $oldImage = str_replace('/storage', 'public', $lugar->imagen);
                Storage::delete($oldImage);
            }
            
            $imagenPath = $request->file('imagen')->store('public/lugares');
            $data['imagen'] = Storage::url($imagenPath);
        }

        $lugar->update($data);

        return redirect()->route('Lugares.index')->with('success', 'Lugar actualizado exitosamente');
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