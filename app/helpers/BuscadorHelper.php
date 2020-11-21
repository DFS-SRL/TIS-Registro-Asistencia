<?php

namespace App\helpers;


class BuscadorHelper
{
    public static function normalizar($s)
    {
        $s = self::aplanar($s);
        while (strlen($s) > 0 && $s[0] == ' ') {
            $s = substr($s, 1);
        }
        while (strlen($s) > 0 && $s[strlen($s) - 1] == ' ') {
            $s = substr($s, 0, strlen($s) - 1);
        }
        $res = '';
        $espacio = false;
        for ($i = 0; $i < strlen($s); $i++) {
            if ($s[$i] != ' ') {
                $espacio = false;
                $res .= $s[$i];
            } else {
                if (!$espacio)
                    $res .= ' ';
                $espacio = true;
            }
        }
        return $res;
    }

    public static function separar($s)
    {
        $res = [];
        $porcion = '';
        for ($i = 0; $i < strlen($s); $i++) {
            if ($s[$i] == ' ') {
                array_push($res, $porcion);
                $porcion = '';
            } else
                $porcion .= $s[$i];
        }
        if (strlen($porcion) > 0)
            array_push($res, $porcion);
        return $res;
    }

    public static function coincidencias($buscado, $buscando)
    {
        $buscado = self::aplanar($buscado);
        $res = 0;
        foreach ($buscando as $valor) {
            $res = max($res, self::coincidir($buscado, $valor));
        }
        return $res;
    }

    private static function coincidir($buscado, $buscando)
    {
        $res = 0;
        for ($i = 0; $i < strlen($buscando) - 1; $i++) {
            $buscado = '%' . $buscado . '%';
        }
        for ($i = 0; $i <= strlen($buscado) - strlen($buscando); $i++) {
            $con = 0;
            for ($j = $i; $j < $i + strlen($buscando); $j++) {
                if ($buscado[$j] == $buscando[$j - $i])
                    $con++;
            }
            $res = max($res, $con);
        }
        return $res * 1.0 / strlen($buscando);
    }

    // vuelve minuscula y quita especiales
    private static function aplanar(&$s)
    {
        return strtolower(
            str_replace(
                array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ñ', 'ñ'),
                array('A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'N', 'n'),
                $s
            )
        );
    }
}