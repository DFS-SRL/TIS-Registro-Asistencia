let año = "";
let mes = "";
let dia = "";
$(window).on("load", function () {
    $('.datepicker').datepicker('setDate', new Date());
});

Date.prototype.addDays = function (d) {
    return new Date(this.valueOf() + 864e5 * d);
};

var primerDiaMes;

$("#sandbox-container").datepicker({
    enddate: new Date().getFullYear(),
    minViewMode: 1,
    language: "es",
    format: "mm/yyyy",
    // clearBtn: true,
    autoclose: true,
});


$("#sandbox-container").on("change", function () {
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
function stap(dia) {
    step(Math.floor((dia - fin.getDate()) / 7));
}
function step(s) {
    actualizarMesAnio();
    var max = nroSemanas();

    var $inputLoop = $("#inputLoop");
    var date = $("#sandbox-container");

    if (date[0].value !== "") {
        var value = $inputLoop.val();
        if (value === "") value = 1;
        value = parseInt(value, 10) + parseInt(s, 10);
        if (value > max) {
            value = value % max;
            primerDiaMes.setMonth(primerDiaMes.getMonth() + 1);
            actualizarMesAnio();
        } else if (value < 1) {
            primerDiaMes.setMonth(primerDiaMes.getMonth() - 1);
            value = nroSemanas();
            actualizarMesAnio();
        }
        if (esFechaValida(value)) {
            $inputLoop.val(value);

            setRangoSemana(value);
        }
    } else {
        primerDiaMes = null;
        actualizarMesAnio();
    }
}

function nroSemanas() {
    var semanas = 0;
    var ini, fin;

    if (primerDiaMes) {
        do {
            ini = primerDiaMes.addDays(
                -(primerDiaMes.getDay() - 1) + semanas * 7
            );
            fin = ini.addDays(5);
            semanas++;
        } while (fin.getMonth() === primerDiaMes.getMonth());
    }

    return semanas - 1;
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
    var ini = primerDiaMes.addDays(
        -(primerDiaMes.getDay() - 1) + (semana - 1) * 7
    );
    var hoy = new Date();
    return ini < hoy;
}
var fin;
function setRangoSemana(semana) {
    var ini = primerDiaMes.addDays(
        -(primerDiaMes.getDay() - 1) + (semana - 1) * 7
    );
    fin = ini.addDays(5);

    var $p = $("#rangoSemana");
    dia = fin.getDate();
    $p[0].innerHTML =
        "Del " +
        ini.getDate() +
        "/" +
        (ini.getMonth() + 1) +
        " al " +
        fin.getDate() +
        "/" +
        (fin.getMonth() + 1);
}

function actualizarMesAnio() {
    if (primerDiaMes) {
        $("#sandbox-container").val(
            primerDiaMes.getMonth() + 1 + "/" + primerDiaMes.getFullYear()
        );
    } else {
        $("#sandbox-container").val("");
        $("#rangoSemana")[0].innerHTML = "Del __/__ al __/__";
    }
}

function verInforme(unidad) {
    var radios = document.getElementsByName("informe");
    var tipoAcademico = "";
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            tipoAcademico = radios[i].value;
            break;
        }
    }
    date = fin.getDate();
    month = fin.getMonth();
    mesanio = $("#sandbox-container")[0].value;
    if (date <= "9") date = "0" + date;
    if (mesanio[1] == "/") mesanio = "0" + mesanio;
    fecha = date + "/" + mesanio;
    fecha =
        fecha.substr(6) + "-" + fecha.substr(3, 2) + "-" + fecha.substr(0, 2);
    window.location.href =
        "/informes/semanal/" + tipoAcademico + "/" + unidad + "/" + fecha;
}
