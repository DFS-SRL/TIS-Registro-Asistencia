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