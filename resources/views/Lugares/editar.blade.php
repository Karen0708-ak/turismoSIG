@extends('layout.app')
@section('contenido')

<div class="row justify-content-center">
    <div class="col-md-11  p-4 rounded text-white">
        <form action="{{ route('Lugares.update', $lugar->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h1 class="text-white mb-4">Editar Un Lugar Turístico</h1>

            <div class="row">
                {{-- Primera columna: datos básicos --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><b>Nombre del lugar:</b></label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $lugar->nombre) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label"><b>Descripción del lugar:</b></label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required>{{ old('descripcion', $lugar->descripcion) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label"><b>Categoría:</b></label>
                        <select class="form-select" name="categoria" id="categoria" required>
                            <option value="Mirador" {{ $lugar->categoria == 'Mirador' ? 'selected' : '' }}>Mirador</option>
                            <option value="Museo" {{ $lugar->categoria == 'Museo' ? 'selected' : '' }}>Museo</option>
                            <option value="Parque" {{ $lugar->categoria == 'Parque' ? 'selected' : '' }}>Parque</option>
                            <option value="Iglesia" {{ $lugar->categoria == 'Iglesia' ? 'selected' : '' }}>Iglesia</option>
                            <option value="Otro" {{ $lugar->categoria == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>

                {{-- Segunda columna: imagen --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="imagen" class="form-label"><b>Imagen del lugar:</b></label>
                        <input type="file" class="form-control" name="imagen" id="imagen">
                        @isset($lugar->imagen)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $lugar->imagen) }}" alt="Imagen actual" style="max-width: 50%; border: 1px solid #ccc;">
                            <p class="text-muted mt-2">Imagen actual</p>
                        </div>
                        @endisset
                    </div>
                </div>

                {{-- Tercera columna: coordenadas y mapa --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="latitud" class="form-label"><b>Latitud:</b></label>
                        <input type="text" class="form-control" name="latitud" id="latitud" value="{{ old('latitud', $lugar->latitud) }}" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="longitud" class="form-label"><b>Longitud:</b></label>
                        <input type="text" class="form-control" name="longitud" id="longitud" value="{{ old('longitud', $lugar->longitud) }}" required readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Ubicación en el mapa:</b></label>
                        <div id="mapa-lugar" style="height: 300px; width: 100%; border: 1px solid #fff;"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('Lugares.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
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

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });

        map.addListener('click', (event) => {
            const newPosition = event.latLng;
            marker.setPosition(newPosition);
            document.getElementById("latitud").value = newPosition.lat();
            document.getElementById("longitud").value = newPosition.lng();
        });
    }
</script>

<script>
    $("#imagen").fileinput({
        language: "es",
        allowedFileExtensions: ["png", "jpg", "jpeg"],
        showCaption: false,
        dropZoneEnabled: true,
        showClose: false
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNQX31CHvoHAv2mgRTHF2C0-Hf5K2uOcg&callback=initMap">
</script>

@endsection
