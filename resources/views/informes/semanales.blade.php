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

    <link rel="stylesheet" href="/css/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src='/js/bootstrap-input-spinner.js'></script>
    <script type="text/javascript" src='/js/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.min.js'></script>
    <script type="text/javascript" src='/js/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.es.min.js'></script>

    <style>
        .esquina-redondeada {
            border-style: solid;
            border-radius: 25px;
            padding: 20px;
            border-color: black;
        }

        .opciones {
            background: white;
            color: black;
        }

        .espaciado {
            margin-bottom: 30px;
            margin-top: 30px;
        }

        .datepicker-switch,
        .prev,
        .next,
        .clear {
            color: white;
        }

        .input-group-prepend,
        .input-group-append {
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
                {{-- <h2 class="textoBlanco">FACULTAD: {{ $unidad->facultad }}</h2>
                <h2 class="textoBlanco">DEPARTAMENTO: {{ $unidad->nombre }} </h2> --}}
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
            <form>
                <div class="col-12 opciones espaciado esquina-redondeada">
                    <input type="radio" id="docente" name="informe" value="docente">
                    <label for="docente">Docente</label><br>
                    <input type="radio" id="auxiliarDoc" name="informe" value="auxiliarDoc">
                    <label for="auxiliarDoc">Auxiliares de Docencia</label><br>
                    <input type="radio" id="auxLabo" name="informe" value="auxLabo">
                    <label for="auxLabo">Auxiliares de Laboratior</label>
                </div>

                <div class="col-12 espaciado">
                    {{-- <input class="col-9" name="startDate" id="startDate"
                        class="date-picker" data-date="" /> --}}
                    <div class="input-group">
                        <label class="col-3 align-self-center" for="startDate">Mes/Año: </label>
                        <input id="sandbox-container" type="text" class="form-control col-8 ml-3"
                            data-date-end-date="0d" name="startDate">
                    </div>
                </div>

                <div class="col-12 espaciado">
                    {{-- <label for="semana">Semana: </label>
                    <input class="form-control" name="semana" step="1" type="number" id="inputLoop" value="1"
                        data-decimals="0" min="0" max="5" /> --}}

                    <div class="input-group">
                        <label for="semana" class="align-self-center">Semana: </label>

                        <div class="input-group-prepend ml-3">
                            <button onclick="step(-1)" style="min-width: 2.5rem"
                                class="btn btn-decrement btn-outline-secondary btn-minus boton" type="button">
                                <strong>−</strong>
                            </button>
                        </div>

                        <input type="text" inputmode="decimal" style="text-align: center" name="semana"
                            class="form-control " placeholder="" id="inputLoop" value="" disabled>

                        <div class="input-group-append">
                            <button onclick="step(1)" style="min-width: 2.5rem"
                                class="btn btn-increment btn-outline-secondary btn-plus boton" type="button">
                                <strong>+</strong>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p id="rangoSemana">Del __/__ al __/__</p>
                    </div>

                </div>
            </form>
        </div>

        <div class="espaciado float-right">
            <button class="boton btn btn-success textoNegro">Ver Informe</button>
        </div>

    </div>

</body>

<script>
    $(window).on('unload', function() {
        $("#inputLoop").val("");
        $('#rangoSemana')[0].innerHTML = ("Del __/__ al __/__");
        $('#sandbox-container').val("");
    });

    Date.prototype.addDays = function(d) {
        return new Date(this.valueOf() + 864E5 * d);
    };

    var primerDiaMes;

    $('#sandbox-container').datepicker({
        enddate: 2020,
        minViewMode: 1,
        language: "es",
        format: "mm/yyyy",
        clearBtn: true
    });

    $("#sandbox-container").on("change", function() {
        var x = $(this).val();
        if (x) {
            $("#inputLoop").val("1");
            var data = $("#sandbox-container").val().split("/");
            data.splice(1, 0, "01");
            primerDiaMes = new Date(data[0] + "/" + data[1] + "/" + data[2]);
            setRangoSemana(1);
        } else {
            $("#inputLoop").val("");
            primerDiaMes = null;
            actualizarMesAnio();
        }
    });

    function step(s) {
        var max = nroSemanas();

        var $inputLoop = $("#inputLoop");
        var date = $('#sandbox-container');

        if (date[0].value !== "") {
            var value = $inputLoop.val();
            if (value === "")
                value = 1;
            value = parseInt(value, 10) + parseInt(s, 10);
            if (value > max) {
                value = value % max;
                primerDiaMes.setMonth(primerDiaMes.getMonth() + 1);
                actualizarMesAnio();
            } else if (value < 1) {
                value = max + parseInt(value, 10) % max;
                primerDiaMes.setMonth(primerDiaMes.getMonth() - 1);
                actualizarMesAnio();
            }
            if (esFechaValida(value)) {
                $inputLoop.val(value)

                setRangoSemana(value)
            }
        } else {
            primerDiaMes = null;
            actualizarMesAnio();
        }
    }

    
    function nroSemanas(){
        var semanas = 0;
        var ini, fin;
        
        do{
            ini = primerDiaMes.addDays(-(primerDiaMes.getDay() - 1) + (semanas) * 7);
            fin = ini.addDays(5);
            semanas++;
        }while(ini.getMonth() === primerDiaMes.getMonth() || fin.getMonth() === primerDiaMes.getMonth());

        return semanas-1;
    }

    function weekCount(year, month_number, startDayOfWeek) {
        // month_number is in the range 1..12

        // Get the first day of week week day (0: Sunday, 1: Monday, ...)
        var firstDayOfWeek = startDayOfWeek || 0;

        var firstOfMonth = new Date(year, month_number - 1, 1);
        var lastOfMonth = new Date(year, month_number, 0);
        var numberOfDaysInMonth = lastOfMonth.getDate();
        var firstWeekDay = (firstOfMonth.getDay() - firstDayOfWeek + 7) % 7;

        var used = firstWeekDay + numberOfDaysInMonth;

        return Math.ceil(used / 7);
    }

    function esFechaValida(semana) {
        var ini = primerDiaMes.addDays(-(primerDiaMes.getDay() - 1) + (semana - 1) * 7);
        var hoy = new Date();
        return ini < hoy;
    }

    function setRangoSemana(semana) {
        var ini = primerDiaMes.addDays(-(primerDiaMes.getDay() - 1) + (semana - 1) * 7);
        var fin = ini.addDays(5);

        var $p = $('#rangoSemana');
        $p[0].innerHTML = "Del " + ini.getDate() + "/" + (ini.getMonth() + 1) +
            " al " + fin.getDate() + "/" + (fin.getMonth() + 1);
    }

    function actualizarMesAnio() {
        if (primerDiaMes)
            $('#sandbox-container').val((primerDiaMes.getMonth() + 1) + "/" + primerDiaMes.getFullYear())
        else{
            $('#sandbox-container').val("");
            $('#rangoSemana')[0].innerHTML = ("Del __/__ al __/__");
        }
    }

</script>

</html>
