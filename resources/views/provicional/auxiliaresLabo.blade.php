@extends('/provicional/usuarios')
@section('tipoUsuario')
    Auxiliares de laboratorio
@endsection
@section('usuarios')
    
    @forelse ($auxiliaresLabo as $auxLabo)
    <li class="list-group-item linkMateria lista">
        <a href="{{ route('auxiliarLabo', $auxLabo->usuario_codSis) }}">{{$auxLabo->nombre}}</a>
    </li>
    @empty
    <h3 class="textoBlanco">No hay auxiliares registrados</h3>
    @endforelse
    <div class="mt-3">
    {{$auxiliaresLabo->links()}}
    </div>
@endsection