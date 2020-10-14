<?php
// si no da para activar correr comando composer dumpautoload
// devuelve el dia actual
function getDia()
{
    return strtoupper( traducirDia( date("l") ) );
    //return 'MARTES';
}

// devuelve la fecha actual
function getFecha()
{
    return date("d/m/Y");
    //return "12/10/2020";
}

// traduce el dia de semana de ingles a español
// si se puede, cambiar a __()
function traducirDia($dia) {
    if ($dia == "Monday") return "Lunes";
    if ($dia == "Tuesday") return "Martes";
    if ($dia == "Wednesday") return "Miercoles";
    if ($dia == "Thursday") return "Jueves";
    if ($dia == "Friday") return "Viernes";
    throw new Exception("Se esperaba un dia de la semana en ingles");
    
}