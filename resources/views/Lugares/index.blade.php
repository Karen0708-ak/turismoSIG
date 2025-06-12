@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color:white;">Puntos de Interés Turísticos</h1>
        <div>
            <a href="{{ url ('Lugares/mapa') }}" class="btn btn-primary">
                Ver mapa Global
            </a>
            <a href="{{ route('Lugares.create') }}" class="btn btn-success">Agregar Nuevo Lugar</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('Lugares.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="categoria" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->categoria }}" {{ request('categoria') == $categoria->categoria ? 'selected' : '' }}>
                                    {{ $categoria->categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filtrar por:</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" id="tbl_lugares">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Ubicación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody style="color:white;">
                @forelse($lugares as $lugar)
                <tr>
                    <td>{{ $lugar->nombre }}</td>
                    <td>{{ Str::limit($lugar->descripcion, 50) }}</td>
                    <td>{{ $lugar->categoria }}</td>
                    <td>
                        @if($lugar->imagen)
                            <img src="{{ asset('storage/' . $lugar->imagen) }}" width="100">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>
                        <small>Lat: {{ $lugar->latitud }}</small><br>
                        <small>Lng: {{ $lugar->longitud }}</small>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('Lugares.edit', $lugar->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('Lugares.destroy', $lugar->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay lugares turisticos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($lugares->hasPages())
        <div class="d-flex justify-content-center">
            {{ $lugares->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
<script>
    $(document).ready(function() {
        let table = new DataTable('#tbl_lugares', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
            },
            dom: 'Bfrtip', 
            buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print'
            ]
        });
    });
</script>
@endsection