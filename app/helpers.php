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