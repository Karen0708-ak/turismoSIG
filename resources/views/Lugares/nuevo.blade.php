@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <div class="bg-black p-4 rounded text-white">
    <h1 class="text-white">Registrar un Nuevo Lugar</h1><br>
    <form action="{{ route('Lugares.store') }}" method="post" enctype="multipart/form-data" id="frm_nuevo_lugar">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><b>Nombre:</b></label>
                        <input class="form-control" type="text" name="nombre" id="nombre">
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                        <input class="form-control" type="text" name="descripcion" id="descripcion">
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label"><b>Categoría:</b></label>
                        <select class="form-select" name="categoria" id="categoria">
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="Mirador">Mirador</option>
                            <option value="Museo">Museo</option>
                            <option value="Parque">Parque</option>
                            <option value="Iglesia">Iglesia</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label"><b>Imagen:</b></label>
                        <input class="form-control" type="file" name="imagen" id="imagen">
                    </div>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="latitud" class="form-label"><b>Latitud:</b></label>
                        <input class="form-control" readonly type="text" name="latitud" id="latitud">
                    </div>

                    <div class="mb-3">
                        <label for="longitud" class="form-label"><b>Longitud:</b></label>
                        <input class="form-control" readonly type="text" name="longitud" id="longitud">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Seleccione la ubicación en el mapa:</b></label>
                        <div id="mapa_cliente" style="border:1px solid black; height:300px; width:100%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-success" type="submit">Guardar</button>
                <a class="btn btn-danger" href="{{ route('Lugares.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!-- Scripts -->
<script type="text/javascript">
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };

        const mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const marcador = new google.maps.Marker({
            position: centro,
            map: mapa,
            title: "Seleccione la dirección",
            draggable: true
        });

        google.maps.event.addListener(marcador, 'dragend', function (event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
    }

    // Esta línea hace que el mapa se cargue correctamente
    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNQX31CHvoHAv2mgRTHF2C0-Hf5K2uOcg&callback=initMap">
</script>
<script>
    $("#frm_nuevo_lugar").validate({
        rules:{
            "nombre":{
                required:true,
                minlength:5,// cuenta caracteres 
                maxlength:15// caracteres maximos
            },
            "descripcion":{
                required:true,
                minlength:7,// cuenta caracteres 
                maxlength:100// caracteres maximos
            },
            "categoria":{
                required:true
            },
            "imagen":{
                required:true
            },
            "latitud":{
                required:true

            },
            "longitud":{
                required:true
            }
        },
        messages:{
            "nombre":{
                required:"Por favor el Campo es obligatorio",
                minlength:"Debe ingresar minimo 5 caracteres",// cuenta caracteres 
                maxlength:"Debe ingresar maxima 15 caracteres"// caracteres maximos
            },
            "descripcion":{
                required:"Por favor el Campo es obligatorio",
                minlength:"Debe ingresar minimo 7 caracteres",// cuenta caracteres 
                maxlength:"Debe ingresar maxima 100 caracteres"// caracteres maximos
            },
            "categoria":{
                required:"Por favor el Campo es obligatorio"
            },
            "imagen":{
                required:"Por favor el Campo es obligatorio"
            },
            "latitud":{
                required:"Por favor el Campo es obligatorio",
            },
            "longitud":{
                required:"Por favor el Campo es obligatorio"
            }
        }
    });
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
@endsection
