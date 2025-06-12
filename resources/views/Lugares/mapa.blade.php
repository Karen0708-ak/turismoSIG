@extends('layout.app')
@section('contenido')
<div class="container">
    <h1 class="text-center my-4">Mapa de Puntos de Interés Turístico</h1>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <select id="filtro-categoria" class="form-select">
                <option value="todos">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <a href="{{ route('Lugares.index') }}" class="btn btn-primary">Ver Listado</a>
            <a href="{{ route('Lugares.create') }}" class="btn btn-success">Agregar Nuevo</a>
        </div>
    </div>
    
    <div id="mapa-lugares" style="border:2px solid #ddd; height:600px; width:100%; border-radius:8px;"></div>
</div>

<script type="text/javascript">
    let map;
    let markers = [];
    let infoWindows = [];

    function initMap() {
        const center = { lat: -0.9374805, lng: -78.6161327 };
        
        map = new google.maps.Map(document.getElementById('mapa-lugares'), {
            center: center,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });

        // Agregar marcadores iniciales
        @foreach($lugares as $lugar)
            addMarker(
                { lat: {{ $lugar->latitud }}, lng: {{ $lugar->longitud }} }, 
                "{{ $lugar->nombre }}", 
                "{{ $lugar->descripcion }}", 
                "{{ $lugar->categoria }}", 
                "{{ $lugar->imagen }}",
                "{{ route('Lugares.edit', $lugar->id) }}",
                "{{ route('Lugares.destroy', $lugar->id) }}"
            );
        @endforeach

        // Configurar el filtro
        document.getElementById('filtro-categoria').addEventListener('change', function() {
            const categoria = this.value;
            
            fetch(`/Lugares/filtrar?categoria=${categoria}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar marcadores existentes
                    clearMarkers();
                    
                    // Agregar nuevos marcadores filtrados
                    data.forEach(lugar => {
                        addMarker(
                            { lat: parseFloat(lugar.latitud), lng: parseFloat(lugar.longitud) }, 
                            lugar.nombre, 
                            lugar.descripcion, 
                            lugar.categoria, 
                            lugar.imagen,
                            `/Lugares/${lugar.id}/edit`,
                            `/Lugares/${lugar.id}`
                        );
                    });
                });
        });

        // Permitir agregar nuevos lugares haciendo clic en el mapa
        map.addListener('click', (event) => {
            if (confirm('¿Desea agregar un nuevo punto de interés en esta ubicación?')) {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                window.location.href = `/Lugares/create?latitud=${lat}&longitud=${lng}`;
            }
        });
    }

    function addMarker(position, nombre, descripcion, categoria, imagen, editUrl, deleteUrl) {
        // Icono personalizado basado en categoría
        let iconUrl;
        switch(categoria.toLowerCase()) {
            case 'mirador':
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/2972/2972185.png';
                break;
            case 'museo':
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/2972/2972215.png';
                break;
            case 'parque':
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/2972/2972156.png';
                break;
            case 'iglesia':
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/2972/2972225.png';
                break;
            default:
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/684/684908.png';
        }

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: nombre,
            icon: {
                url: iconUrl,
                scaledSize: new google.maps.Size(40, 40)
            }
        });

        const contentString = `
            <div style="max-width: 300px;">
                <h5>${nombre}</h5>
                <p><strong>Categoría:</strong> ${categoria}</p>
                <p>${descripcion}</p>
                ${imagen ? `<img src="${imagen}" style="max-width: 100%; height: auto; margin-bottom: 10px;">` : ''}
                <div class="d-flex justify-content-between">
                    <a href="${editUrl}" class="btn btn-sm btn-primary">Editar</a>
                    <form action="${deleteUrl}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                    </form>
                </div>
            </div>
        `;

        const infoWindow = new google.maps.InfoWindow({
            content: contentString
        });

        marker.addListener('click', () => {
            // Cerrar todas las ventanas de información primero
            infoWindows.forEach(iw => iw.close());
            infoWindow.open(map, marker);
        });

        markers.push(marker);
        infoWindows.push(infoWindow);
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
        infoWindows = [];
    }
</script>
@endsection