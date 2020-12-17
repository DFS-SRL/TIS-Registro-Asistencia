<nav class="boton navbar mb-4">
    <div class="container justify-content-start">
        <a class="navbar-brand text-white" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>
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
                <a class="nav-link text-white {{ setActive('docentes') }}" href="{{ route('docentes') }}">
                    Docentes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('auxiliaresDoc') }}" href="{{ route('auxiliaresDoc') }}">
                    Auxiliares de docencia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('auxiliaresLabo') }}" href="{{ route('auxiliaresLabo') }}">
                    Auxiliares de laboratorio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ setActive('departamentos') }}" href="{{ route('departamentos') }}">
                    Departamentos
                </a>
            </li>
            @auth
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="text-white btn btn-danger">Cerrar Sesión</a>
                </li>
            @endauth
        </ul>
        </div>
    </div>
</nav>