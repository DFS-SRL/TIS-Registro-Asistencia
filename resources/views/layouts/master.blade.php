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
    @yield('content')
</body>

@yield('script-footer')
</html>