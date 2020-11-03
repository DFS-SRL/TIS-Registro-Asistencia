<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informes Semanales</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src='js/bootstrap-input-spinner.js'></script>

    <style>
        .esquina-redondeada{
            border-style: solid;
            border-radius: 25px;
            padding: 20px;
            border-color: black;
        }

        .opciones {
            background: white;
            color: black;
        }

        .espaciado{
            margin-bottom: 30px;
            margin-top: 30px;
        }

        .ui-datepicker-calendar {
            display: none;
        }

        .ui-widget {
            font-size: .7em;
        }

        .input-group-prepend, .input-group-append{
            color: black;
            background: white;
        }
        

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="textoBlanco">FACULTAD: {{ $unidad['facultad'] }}</h2>
                <h2 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h2>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="textoBlanco">
                    Seleccion de semana para visualización de informes de asistencia semanales
                </p>
            </div>
        </div>

        <div class="row textoBlanco justify-content-center esquina-redondeada" style="background:#7C7365;">
            <form method="POST" action="{{ route('informes.semanales') }}">
                <div class="col-12 opciones espaciado esquina-redondeada">
                    <input type="radio" id="docente" name="informe" value="docente">
                    <label for="docente">Docente</label><br>
                    <input type="radio" id="auxiliarDoc" name="informe" value="auxiliarDoc">
                    <label for="auxiliarDoc">Auxiliares de Docencia</label><br>
                    <input type="radio" id="auxLabo" name="informe" value="auxLabo">
                    <label for="auxLabo">Auxiliares de Laboratior</label>
                </div>

                <div class="col-12 espaciado">
                    <label class="col-2" for="startDate">Date: </label>
                    <input class="col-9" name="startDate" id="startDate" class="date-picker" data-date="" />
                </div>

                <div class="col-12 espaciado">
                    {{-- <label for="semana">Semana: </label>
                    <input class="form-control" name="semana" step="1" type="number" id="inputLoop" value="1"
                        data-decimals="0" min="0" max="5" /> --}}

                    <div class="input-group  ">
                        <label for="semana">Semana: </label>

                        <div class="input-group-prepend">
                            <button onclick="step(-1, {{ $unidad['semanas'] }})" style="min-width: 2.5rem" 
                            class="btn btn-decrement btn-outline-secondary btn-minus" type="button">
                                <strong>−</strong>
                            </button>
                        </div>

                        <input type="text" inputmode="decimal" style="text-align: center" name="semana"
                        class="form-control " placeholder="" id="inputLoop" value="1" disabled>
                        
                        <div class="input-group-append">
                            <button onclick="step(1, {{ $unidad['semanas'] }})" style="min-width: 2.5rem" 
                            class="btn btn-increment btn-outline-secondary btn-plus" type="button">
                                <strong>+</strong>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p>Del {{ $unidad['fechaIni'] }} al {{ $unidad['fechaFin'] }}</p>
                    </div>

                </div>
            </form>
        </div>

        <div class="espaciado float-right">
            <button class="boton btn btn-success">Ver Informe</button>
        </div>
    </div>

</body>

<script>
    var $inputLoop = $("#inputLoop");
    function step (s, max) {
        var value = $inputLoop.val();
        value = parseInt(value, 10) + parseInt(s, 10);
        if(value > max){
            value = value % max;
        }else if(value < 1){
            value = max + parseInt(value, 10) % max;
        }
        $inputLoop.val(value)
    }
</script>

<script>

    $(function() {
        var myDate = $("#startDate").attr('data-date');


        $('#startDate').datepicker({
            yearRange: "-20:+0",
            maxDate: '-1M',
            changeMonth: true,
            changeYear: true,
            setDate: myDate,
            showButtonPanel: false,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
        $('#startDate').datepicker('setDate', myDate);
    });

</script>

</html>
