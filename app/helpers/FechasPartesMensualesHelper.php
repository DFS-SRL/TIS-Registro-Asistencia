<?php

namespace App\helpers;


class FechasPartesMensualesHelper
{
    public static function añadirMesPartes($ultimosPartes){
        $bMeses = array("void","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        for($i = 0, $size = count($ultimosPartes); $i < $size; ++$i) {
            $fecha = explode("-",$ultimosPartes[$i]["fecha_ini"]);
            $mes   = $fecha[1];
            $ultimosPartes[$i]["mes"] = $bMeses[$mes]; 
        }
        return $ultimosPartes;     
    }
}

