@extends('/provicional/usuarios')
@section('tipoUsuario')
    Auxiliares de docencia
@endsection
@section('usuarios')
    
    @forelse ($auxiliaresDoc as $auxDoc)
    <li class="list-group-item linkMateria lista">
        <a href="{{ route('auxiliarDoc', $auxDoc->usuario_codSis) }}">{{$auxDoc->nombre}}</a>
    </li>
    @empty
    <h3 class="textoBlanco">No hay auxiliares registrados</h3>
    @endforelse
    <div class="mt-3">
    {{$auxiliaresDoc->links()}}
    </div>
@endsection