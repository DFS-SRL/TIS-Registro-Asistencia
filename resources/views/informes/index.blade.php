<p> esta es la vista de informes del departamento {{ $unidad->nombre }} </p>
<p> de la facultad de {{ $unidad->facultad }}  </p>
<form method="POST"  action="{{ route('informes.subir') }}">
    @csrf
    <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
    <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
    <button class="btn btn-success">SUBIR</button> 
</form>