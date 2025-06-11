@extends('layout.app')

@section('contenido')

<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;"> {{-- Limita el ancho a 1000px --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Listado de Clientes</h2>
            <a href="#" class="btn btn-success">Agregar Nuevo Cliente</a>
            <a href="#" class="btn btn-success">Ver mapa Global</a>
        </div>
        

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $clienteTemporal)
                    <tr>
                        <td>{{ $clienteTemporal->apellido }}</td>
                        <td>{{ $clienteTemporal->nombre }}</td>
                        <td>{{ $clienteTemporal->cedula }}</td>
                        <td>{{ $clienteTemporal->latitud }}</td>
                        <td>{{ $clienteTemporal->longitud }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary me-1">Editar</a>

                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay clientes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection