@extends('/provicional/usuarios')
@section('tipoUsuario')
    Docentes
@endsection
@section('usuarios')
    
    @forelse ($docentes as $docente)
    <li class="list-group-item linkMateria lista">
        <a href="/planillas/semanal/docente/{{$docente->usuario_codSis}}">{{$docente->nombre}}</a>
    </li>
    @empty
    <h3 class="textoBlanco">No hay docentes registrados</h3>
    @endforelse
    <div class="mt-3">
    {{$docentes->links()}}
    </div>
@endsection