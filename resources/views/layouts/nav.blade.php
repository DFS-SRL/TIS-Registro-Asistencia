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
        </ul>
        </div>
    </div>
</nav>