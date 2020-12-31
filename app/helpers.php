<?php

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

// si no da para activar correr comando composer dumpautoload
// devuelve el dia actual
function getDia()
{
    return traducirDia(date("l"));
    //return 'MARTES';
}

// devuelve la fecha actual
function getFecha()
{
    return date("d/m/Y");
    //return "12/10/2020";
}

//devuelve el primer dia del mes
function primerDiaMes()
{
    $fecha = date("m/d/Y");
    $fecha[3] = '0';
    $fecha[4] = '1';
    return $fecha;
}

//diferencia entre hoy y el primer dia del mes
function dia()
{
    return (int)date("d") + 4 - (int)date("l");
}

//devuelve la fecha actual con formato
function getFechaF($formato = null)
{
    return date("Y-m-d");
}

// formatea fecha de Y-m-d a d/m/Y
function formatoFecha($fecha)
{
    return date('d/m/Y', strtotime($fecha));
}

// traduce el dia de semana de ingles a español en mayusculas
// si se puede, cambiar a __()
function traducirDia($dia)
{
    if ($dia == "Monday") return "LUNES";
    if ($dia == "Tuesday") return "MARTES";
    if ($dia == "Wednesday") return "MIERCOLES";
    if ($dia == "Thursday") return "JUEVES";
    if ($dia == "Friday") return "VIERNES";
    if ($dia == "Saturday") return "SABADO";
    if ($dia == "Sunday") return "DOMINGO";
    throw new Exception("Se esperaba un dia de la semana en ingles");
}

// lo mismo pero la entrada son numeros
function traducirDia1($dia)
{
    $dias = [
        '0' => "DOMINGO",
        '1' => "LUNES",
        '2' => "MARTES",
        '3' => "MIERCOLES",
        '4' => "JUEVES",
        '5' => "VIERNES",
        '6' => "SABADO"
    ];
    return $dias[$dia];
}

// devuelve un arreglo con la fecha de cada dia de la semana actual
function getFechasDeSemanaActual()
{
    $d = strtotime("last monday", strtotime("tomorrow"));
    return [
        "LUNES" =>      date("d/m/Y", $d),
        "MARTES" =>     date("d/m/Y", strtotime("+1 day", $d)),
        "MIERCOLES" =>  date("d/m/Y", strtotime("+2 days", $d)),
        "JUEVES" =>     date("d/m/Y", strtotime("+3 days", $d)),
        "VIERNES" =>    date("d/m/Y", strtotime("+4 days", $d)),
        "SABADO" =>     date("d/m/Y", strtotime("+5 days", $d)),
    ];
}

// fecha en formato Y-m-d amigable con URL y DB
function getFechasDeSemanaEnFecha($fecha)
{
    $d = strtotime("last monday", strtotime("+1 day", strtotime($fecha)));
    return [
        date("Y-m-d", $d),
        date("Y-m-d", strtotime("+1 day", $d)),
        date("Y-m-d", strtotime("+2 days", $d)),
        date("Y-m-d", strtotime("+3 days", $d)),
        date("Y-m-d", strtotime("+4 days", $d)),
        date("Y-m-d", strtotime("+5 days", $d)),
    ];
}

// cambia una fecha en formato d/m/Y en Y-m-d amigable con DB
function convertirFechaDMYEnYMD($fecha)
{
    $separada = explode("/", $fecha);
    $fechaFormateada = $separada[2] . "-" . $separada[1] . "-" . $separada[0];
    return date("Y-m-d", strtotime($fechaFormateada));
}

// compara dos dias de semana tomando LUNES como el primer dia
function compararDias($diaA, $diaB)
{
    $posicion = [
        "LUNES" =>      0,
        "MARTES" =>     1,
        "MIERCOLES" =>  2,
        "JUEVES" =>     3,
        "VIERNES" =>    4,
        "SABADO" =>     5,
        "DOMINGO" =>    6,
    ];
    return $posicion[$diaA] - $posicion[$diaB];
}

// tiempo dado una hora
function tiempoHora($hora)
{
    return Carbon::createFromFormat('d/m/Y H:i:s',  '01/01/2000 ' . $hora);
}

// tiempo dado una fecha
function tiempoFecha($fecha)
{
    return Carbon::createFromFormat('Y-m-d H:i:s',  $fecha . ' 12:00:00');
}

// parametro por referencia, devuelve fecha 16 a 15 del ultimo mes e instancia Carbon de la inicial
function calcularFechasMes($fecha, &$t, &$fechaInicio, &$fechaFin)
{
    $t = tiempoFecha($fecha);
    if ($t->day <= 15)
        $t->subMonth();
    $t->day = 15;
    $fechaFin = $t->toDateString();
    $t->subMonth();
    $t->addDay();
    $fechaInicio = $t->toDateString();
}

// activar ruta en navbar
function setactive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

// paginar colecciones
function paginate($items, $perPage = 10, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

    $items = $items instanceof Collection ? $items : Collection::make($items);

    return new LengthAwarePaginator(
        $items->forPage($page, $perPage),
        $items->count(),
        $perPage,
        $page,
        [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]
    );
}

function aumentarMes($fecha)
{
    $fecha = Carbon::createFromFormat('Y-m-d H:i:s',  $fecha . ' 12:00:00');
    $fecha->addMonth();
    return $fecha->toDateString();
}