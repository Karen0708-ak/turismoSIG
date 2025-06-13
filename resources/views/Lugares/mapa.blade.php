@extends('layout.app')
@section('contenido')
<br>
<h1>Mapa de Lugares</h1>
<br><br>

<div id="mapa-lugar" style="border:1px solid black; height:600px; width:100%"></div>

<script type="text/javascript">
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };
        const mapa = new google.maps.Map(document.getElementById('mapa-lugar'), {
            center: centro,
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const lugares = @json($lugar);

        lugares.forEach(lugar => {
            const posicion = {
                lat: parseFloat(lugar.latitud),
                lng: parseFloat(lugar.longitud)
            };

            const imagenUrl = lugar.imagen ? `/storage/${lugar.imagen}` : '/imagen/default.png';

            const marcador = new google.maps.Marker({
                position: posicion,
                map: mapa,
                icon: {
                    url: 'https://cdn-icons-png.freepik.com/256/6501/6501497.png?semt=ais_hybrid',
                    scaledSize: new google.maps.Size(30, 30)
                },
                title: lugar.nombre,
                draggable: false
            });

            const infoWindow = new google.maps.InfoWindow({
    content: `
        <div style="background-color: black; color: white; padding: 5px; border-radius: 5px; max-width: 200px;">
            <strong>${lugar.nombre}</strong><br>
            ${lugar.descripcion || 'Sin descripción'}<br>
            <img src="${imagenUrl}" width="100" height="100" style="margin-top: 5px;">
        </div>
    `
});


            marcador.addListener("mouseover", function () {
                infoWindow.open(mapa, marcador);
            });

            marcador.addListener("mouseout", function () {
                infoWindow.close();
            });
        });
    }

    window.initMap = initMap;
</script>


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-d3jhyJysjrOpa1iPvNlJDL6QHQMPfg&callback=initMap">
</script>
@endsection
