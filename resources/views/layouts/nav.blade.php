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
            <li class="nav-item">
                @if (Auth::check() && App\User::tieneAlMenosUnRol([3]))
                    <a class="nav-link text-white {{ setActive('docente') }}" href="{{ route('docente', auth()->user()->usuario_codSis) }}">
                @else
                    <a class="nav-link text-white {{ setActive('docente') }}">
                @endif
                    Docente
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ setActive('auxiliarDoc') }} {{ setActive('auxiliarLabo') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Auxiliar
                </a>
                <div class="dropdown-menu mostaza" aria-labelledby="navbarDropdown">
                    @if (Auth::check() && App\User::tieneAlMenosUnRol([2]))
                        <a class="dropdown-item nav-link text-white {{ setActive('auxiliarDoc') }}" href="{{ route('auxiliarDoc', auth()->user()->usuario_codSis) }}">
                    @else
                        <a class="dropdown-item nav-link text-white {{ setActive('auxiliarDoc') }}">
                    @endif
                        Auxiliar de docencia
                    </a>
                    @if (Auth::check() && App\User::tieneAlMenosUnRol([1]))
                        <a class="dropdown-item nav-link text-white {{ setActive('auxiliarLabo') }}" href="{{ route('auxiliarLabo', auth()->user()->usuario_codSis) }}">
                    @else
                        <a class="dropdown-item nav-link text-white {{ setActive('auxiliarLabo') }}">
                    @endif
                        Auxiliar de laboratorio
                    </a>
                </div>
            </li>
            <li class="nav-item">
                @if (Auth::check() && auth()->user()->deparatmentoEncargado() != null)
                <a class="nav-link text-white {{-- setActive('departamento') --}}" href="{{ route('departamento', auth()->user()->deparatmentoEncargado()) }}">
                @else
                <a class="nav-link text-white {{-- setActive('departamento') --}}">
                @endif
                    Jefe de departamento
                </a>
            </li>
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