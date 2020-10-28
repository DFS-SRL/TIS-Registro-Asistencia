<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('tipoUsuario')</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    <link rel="stylesheet" href="/css/listaMateriasEstilo.css">
</head>
<body>
    <h1 class="textoBlanco">@yield('tipoUsuario')</h1>
    <div class="container mt-4">
            @yield('usuarios')
    </div>
</body>
</html>