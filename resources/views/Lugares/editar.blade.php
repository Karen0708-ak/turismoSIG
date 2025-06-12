@extends('layout.app')
@section('contenido')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 bg-light p-4 rounded">
        <form action="{{ route('Lugares.update', $lugar->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1>Editar Un Lugar Turístico</h1>

            <div class="mb-3">
                <label for="nombre" class="form-label"><b>Nombre del lugar:</b></label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $lugar->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label"><b>Descripción del lugar:</b></label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required>{{ old('descripcion', $lugar->descripcion) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label"><b>Categoría:</b></label>
                <select class="form-select" name="categoria" id="categoria" required>
                    <option value="Mirador" {{ $lugar->categoria == 'mirador' ? 'selected' : '' }}>Mirador</option>
                    <option value="Museo" {{ $lugar->categoria == 'museo' ? 'selected' : '' }}>Museo</option>
                    <option value="Parque" {{ $lugar->categoria == 'parque' ? 'selected' : '' }}>Parque</option>
                    <option value="Iglesia" {{ $lugar->categoria == 'iglesia' ? 'selected' : '' }}>Iglesia</option>
                    <option value="Otro" {{ $lugar->categoria == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label"><b>Imagen del lugar:</b></label>
                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                @if($lugar->imagen)
                    <div class="mt-2">
                        <img src="{{ $lugar->imagen }}" alt="Imagen actual" style="max-width: 200px;">
                        <p class="text-muted">Imagen actual</p>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="latitud" class="form-label"><b>Latitud:</b></label>
                <input type="text" class="form-control" name="latitud" id="latitud" value="{{ old('latitud', $lugar->latitud) }}" required readonly>
            </div>

            <div class="mb-3">
                <label for="longitud" class="form-label"><b>Longitud:</b></label>
                <input type="text" class="form-control" name="longitud" id="longitud" value="{{ old('longitud', $lugar->longitud) }}" required readonly>
            </div>

            <div id="mapa-lugar" style="height: 300px; width: 100%; margin-bottom: 20px; border: 1px solid #ddd;"></div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('Lugares.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>

<script type="text/javascript">
    function initMap() {
        const initialPosition = { 
            lat: parseFloat(document.getElementById('latitud').value), 
            lng: parseFloat(document.getElementById('longitud').value) 
        };
        
        const map = new google.maps.Map(document.getElementById('mapa-lugar'), {
            center: initialPosition,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            title: "Arrastre para cambiar ubicación",
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });

        // Permitir cambiar la ubicación haciendo clic en el mapa
        map.addListener('click', (event) => {
            const newPosition = event.latLng;
            marker.setPosition(newPosition);
            document.getElementById("latitud").value = newPosition.lat();
            document.getElementById("longitud").value = newPosition.lng();
        });
    }
</script>
@endsection