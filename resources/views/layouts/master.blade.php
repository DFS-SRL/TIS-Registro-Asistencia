<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    {{-- <link rel="stylesheet" href="/css/jquery-ui/jquery-ui.css"> --}}


    <script type="text/javascript" src='/js/jquery/jquery.min.js'></script>
    <script type="text/javascript" src='/js/bootstrap/bootstrap.bundle.min.js'></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
    

    @yield('css')
    @yield('script-head')

</head>
<body>
    <div id="app" class="d-flex flex-column h-screen justify-content-between">
        <header>
            @include('layouts.nav')
            <div class="container">
                @include('layouts.flash-message')
            </div>
        </header>
        
        <main>
            @yield('content')
        </main>

        <footer class="text-center text-white py-3 shadow mt-4">
            {{ config('app.name') }} | Copyright @ {{ date('Y')}}
        </footer>
    </div>
</body>

@yield('script-footer')
</html>