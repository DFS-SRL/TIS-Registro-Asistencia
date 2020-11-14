@include('layouts.flash-message')
<h1>{{ $unidad->nombre }}</h1>
<h3>todos</h3>
<ul>
    @forelse ($todos as $usuario)
        <li>{{ $usuario->nombre }} {{ $usuario->codSis }} roles: @foreach ($usuario->roles as $rol) {{$rol->rol_id}}, @endforeach</li>
    @empty
        <p>no hay personal</p>
    @endforelse
</ul>
<br>
<h3>docentes</h3>
<ul>
    @forelse ($docentes as $usuario)
        <li>{{ $usuario->nombre }} {{ $usuario->codSis }}</li>
    @empty
        <p>no hay docentes</p>
    @endforelse
</ul>
<br>
<h3>auxiliares de docencia</h3>
<ul>
    @forelse ($auxiliaresDoc as $usuario)
        <li>{{ $usuario->nombre }} {{ $usuario->codSis }}</li>
    @empty
        <p>no hay auxiliares de docencia</p>
    @endforelse
</ul>
<br>
<h3>auxiliares de laboratorio</h3>
<ul>
    @forelse ($auxiliaresLabo as $usuario)
        <li>{{ $usuario->nombre }} {{ $usuario->codSis }}</li>
    @empty
        <p>no hay auxiliares de laboratorio</p>
    @endforelse
</ul>