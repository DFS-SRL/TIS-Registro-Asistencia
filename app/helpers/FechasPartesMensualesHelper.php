<?php

namespace App\helpers;


class FechasPartesMensualesHelper
{
    public static function getFechaUltimoParte()
    {            
        $bMeses = array("void","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $date = getdate();
        if($date["mday"]>=16){
            if($date["mon"] == 1){
                $date["mon"] = 12;
                $date["year"] -= 1;
            }else{
                $date["mon"] -= 1;
            }
        }else{
            if($date["mon"] == 1){
                $date["mon"] = 11;
                $date["year"] -= 1;
            }else{
                $date["mon"] -= 2;
            }
        }
        $date["mday"] = 15;
        $mes = $bMeses[$date["mon"]];          

        return ['fecha'=>$date["year"].'-'.$date["mon"].'-'.$date["mday"],'mesParte'=>$mes];
    }

}

