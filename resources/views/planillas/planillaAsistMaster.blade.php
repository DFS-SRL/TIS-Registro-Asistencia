<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h3>PLANILLA DIARIA DE ASISTENCIA</h3>
                <h4>NOMBRE AUXILIAR LABORATORIO:</h4>
                <h4>CODSIS:</h4>
            </div>
            <div class="col-4">
                <h4>DIA:</h4>
                <h4>FECHA:</h4>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">HORARIO</th>
                <th scope="col">CARGO</th>
                <th scope="col">ACTIVIDAD REALIZADA</th>
                <th scope="col">OBSERVACIONES</th>
                <th scope="col">ASISTENCIA</th>
                {{-- <th scope="col">PERMISO</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                </tr>
                <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                </tr>
                <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                </tr>
            </tbody>
            </table>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>