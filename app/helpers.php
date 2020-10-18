<?php
// si no da para activar correr comando composer dumpautoload
// devuelve el dia actual
function getDia()
{
    return traducirDia( date("l") );
    //return 'MARTES';
}

// devuelve la fecha actual
function getFecha()
{
    return date("d/m/Y");
    //return "12/10/2020";
}

//devuelve la fecha actual con formato
function getFechaF($formato)
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
function traducirDia($dia) {
    if ($dia == "Monday") return "LUNES";
    if ($dia == "Tuesday") return "MARTES";
    if ($dia == "Wednesday") return "MIERCOLES";
    if ($dia == "Thursday") return "JUEVES";
    if ($dia == "Friday") return "VIERNES";
    throw new Exception("Se esperaba un dia de la semana en ingles");
}

// devuelve un arreglo con la fecha de cada dia de la semana actual
function getFechasDeSemanaActual() {  
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