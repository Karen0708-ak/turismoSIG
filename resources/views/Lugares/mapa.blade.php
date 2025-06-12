@extends('layout.app')
@section('contenido')
<br>
<h1>Mapa de Lugares</h1>
<br>
<br>
    <div class="" id="mapa-lugar" style="border:1px solid black; height:450px;
                    width:80%"> </div>
<script type="text/javascript">
    function initMap(){
        //alert("mapa ok");
        var latitud_longitud= new google.maps.LatLng(-0.9374805,-78.6161327);
        var mapa=new google.maps.Map(
            document.getElementById('mapa-lugar'),
            {
                center:latitud_longitud,
                zoom:15,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            }
        );
        @foreach($lugar as $lugar)
            var cordenadaCliente= new google.maps.LatLng({{$lugar->latitud}}, 
                                        {{$lugar->longitud}});
            var marcador=new google.maps.Marker({
                position:cordenadaCliente,
                map:mapa,
                icon:{
                        url: 'https://cdn-icons-png.freepik.com/256/6501/6501497.png?semt=ais_hybrid',
                        scaledSize: new google.maps.Size(30, 30),
                title:"{{$lugar->nombre}}",
                draggable:false
                }
            });
        @endforeach
    }
</script>
@endsection