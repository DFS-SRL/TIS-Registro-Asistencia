<nav class="boton navbar mb-4">
    <div class="container justify-content-start">
        <a class="navbar-brand text-white" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>
        @auth
            <div class="col-3 ml-auto">
                <a class="navbar-brand text-white text-right">{{ auth()->user()->name }}</a>
            </div>
        @endauth

        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('home') }}" href="{{ route('home') }}">
                    @lang('Home')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('about') }}" href="{{ route('about') }}">
                    @lang('About')
                </a>
            </li>
            @if (Auth::check() && App\User::tieneAlMenosUnRol([3]))
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('docente') }}" href="{{ route('docente', auth()->user()->usuario_codSis) }}">
                    Docente
                </a>
            </li>
            @endif
            @if (Auth::check() && App\User::tieneAlMenosUnRol([2]))
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('auxiliarDoc') }}" href="{{ route('auxiliarDoc', auth()->user()->usuario_codSis) }}">
                    Auxiliar de docencia
                </a>
            </li>
            @endif
            @if (Auth::check() && App\User::tieneAlMenosUnRol([1]))
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('auxiliarLabo') }}" href="{{ route('auxiliarLabo', auth()->user()->usuario_codSis) }}">
                    Auxiliar de laboratorio
                </a>
            </li>
            @endif
            @if (Auth::check() && auth()->user()->deparatmentoEncargado() != null)
            <li class="nav-item">
                <a class="nav-link text-white {{-- setActive('departamento') --}}" href="{{ route('departamento', auth()->user()->deparatmentoEncargado()) }}">
                    Jefe de departamento
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('facultades') }}" href="{{ route('facultades') }}">
                    Facultades
                </a>
            </li>
            @auth
                <li class="nav-item">
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
    </div>
</nav>