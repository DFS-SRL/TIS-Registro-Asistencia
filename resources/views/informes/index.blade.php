<p> esta es la vista de informes del departamento {{ $unidad->nombre }} </p>
<p> de la facultad de {{ $unidad->facultad }} </p>
<form method="POST" id="formulario" action="{{ route('informes.subir') }}">
    @csrf
    <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
    <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
    @if ($errors->any())
        @foreach ($errors->getMessages() as $key => $error)
            <p> {{ $error[0] }} </p>
            @if ($key == 'nivel1')
                <INPUT class="btn btn-success" TYPE='submit' value='ENVIAR DE TODOS MODOS' name='delete'
                    onClick='return confirmSubmit(true)'>
            @endif
        @endforeach
    @else
        <INPUT class="btn btn-success" TYPE='submit' value='ENVIAR' name='delete' onClick='return confirmSubmit(false)'>
    @endif
</form>

<script LANGUAGE="JavaScript">
    // funcion de confirm box
    function confirmSubmit(fuerza) {
        var agree = confirm("¿Estás seguro de subir los informes?, no habrá marcha atras");
        if (agree) {
            if (fuerza)
                document.getElementById("formulario").action = "{{ route('informes.subirFuerza') }}";
            return true;
        } else
            return false;
    }
    // -->

</script>
