@extends('layout.app')
@section('contenido')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 bg-black p-4 rounded text-white">
        <form action="{{ route('Lugares.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h1>Registrar un Nuevo Lugar</h1>

            <label for="nombre" class="colorf"><b>Nombre:</b></label>
            <input class="form-control" type="text" name="nombre" id="nombre" required><br>

            <label for="descripcion" class="colorf" ><b>Descripción:</b></label>
            <input class="form-control" type="text" name="descripcion" id="descripcion" required><br>

            <div class="mb-3">
                <label for="categoria" class="form-label colorf"><b>Categoría:</b></label>
                <select class="form-select" name="categoria" id="categoria" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <option value="Mirador">Mirador</option>
                    <option value="Museo">Museo</option>
                    <option value="Parque">Parque</option>
                    <option value="Iglesia">Iglesia</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <br>

            <label for="imagen" class="colorf" ><b>Imagen:</b></label>
            <input class="form-control" type="file" name="imagen" id="imagen" accept="image/*"><br>

            <label for="latitud" class="colorf" ><b>Latitud:</b></label>
            <input class="form-control" readonly type="text" name="latitud" id="latitud"><br>

            <label for="longitud" class="colorf" ><b>Longitud:</b></label>
            <input class="form-control" readonly type="text" name="longitud" id="longitud"><br>

            <div id="mapa_cliente" style="border:1px solid black; height:350px; width:100%"></div><br>

            <button class='btn btn-success' type="submit">Guardar</button>
            <a class="btn btn-danger" href="{{ route('Lugares.index') }}">Cancelar</a>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>

<script type="text/javascript">
    function initMap() {
        var latitud_longitud = new google.maps.LatLng(-0.9374805, -78.6161327);
        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: latitud_longitud,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marcador = new google.maps.Marker({
            position: latitud_longitud,
            map: mapa,
            title: "Seleccione la dirección",
            draggable: true
        });
        google.maps.event.addListener(marcador, 'dragend', function (event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
    }
</script>
@endsection