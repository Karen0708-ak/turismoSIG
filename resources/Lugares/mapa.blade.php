@extends('layout.app')
@section('contenido')
<br>
<h1>Mapa de Clientes</h1>
<br>
<div id="mapa-clientes" style="border:2px solid black; height:500px; width:100%;">
</div>
<script type="text/javascript">
    function initMap(){
        //alert("mapa ok");
        var latitud_longitud= new google.maps.LatLng(-0.9374805,-78.6161327);
        var mapa=new google.maps.Map(
            document.getElementById('mapa-clientes'),
            {
                center:latitud_longitud,
                zoom:15,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            }
        );
        @foreach($clientes as $clienteTemporal)
            var cordenadaCliente= new google.maps.LatLng({{$clienteTemporal->latitud}}, 
                                        {{$clienteTemporal->longitud}});
            var marcador=new google.maps.Marker({
                position:cordenadaCliente,
                map:mapa,
                icon: {
                url: 'https://cdn-icons-png.flaticon.com/512/10709/10709443.png',
                scaledSize: new google.maps.Size(50, 50)
                },                
                title:"{{$clienteTemporal->apellido}} {{$clienteTemporal->nombre}}",
                draggable:false
            });
        @endforeach
    }
</script>


@endsection