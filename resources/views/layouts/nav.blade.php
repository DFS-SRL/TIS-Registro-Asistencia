<nav class="boton nav mb-4">
    <div class="container">
        <div class="d-inline-flex navbar-right mb-2 {{ auth()->user() ? 'col-6' : '' }}">
            <a class="navbar-brand text-white" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </div>
        @auth
            <div class="d-inline-flex float-right nav navbar-nav navbar-right mb-2">
                <div class="">
                    <a class="navbar-brand text-white text-right border btn boton" href={{ route('notificaciones') }}>Notificaciones
                        <span class="badge badge-pill badge-dark
                            {{ Auth::user()->usuario->notificacionesNoLeidas()->count() ? '' : 'd-none'}}">
                                {{-- {{ $count }} --}}
                                {{ Auth::user()->usuario->notificacionesNoLeidas()->count() }}
                        </span>
                    </a>
                    <a class="navbar-brand text-white text-right border btn boton">{{ auth()->user()->name }}</a>
                </div>
            </div>
        @endauth
            
        <ul class="d-inline-flex nav nav-pills">
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('home') }}" href="{{ route('home') }}">
                    @lang('Home')
                </a>
            </li>
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('about') }}" href="{{ route('about') }}">
                    @lang('About')
                </a>
            </li>
            @if (Auth::check() && App\User::tieneAlMenosUnRol([3]))
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('docente') }}" href="{{ route('docente', auth()->user()->usuario_codSis) }}">
                    Docente
                </a>
            </li>
            @endif
            @if (Auth::check() && App\User::tieneAlMenosUnRol([2]))
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('auxiliarDoc') }}" href="{{ route('auxiliarDoc', auth()->user()->usuario_codSis) }}">
                    Auxiliar de docencia
                </a>
            </li>
            @endif
            @if (Auth::check() && App\User::tieneAlMenosUnRol([1]))
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('auxiliarLabo') }}" href="{{ route('auxiliarLabo', auth()->user()->usuario_codSis) }}">
                    Auxiliar de laboratorio
                </a>
            </li>
            @endif
            @if (Auth::check() && auth()->user()->deparatmentoEncargado() != null)
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('departamento') }}" href="{{ route('departamento', auth()->user()->deparatmentoEncargado()) }}">
                    Jefe de departamento
                </a>
            </li>
            @endif
            <li class="nav-item border-left border-white">
                <a class="nav-link text-white {{ setActive('facultades') }}" href="{{ route('facultades') }}">
                    Facultades
                </a>
            </li>
            @auth
                <li class="nav-item border-left border-right border-white">
                    <a href="#" class="text-white btn btn-danger"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </ul>
    </div>
</nav>