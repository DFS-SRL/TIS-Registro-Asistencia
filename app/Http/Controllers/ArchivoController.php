<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    // Descargar documento adicional por nombre
    public function descargarPorNombre($nombre) {
        return Storage::download('/documentosAdicionales/'.$nombre);
    }

    // Eliminar un documento adicional
    // La documentacion dice que devuelve un booleano pero no lo probe
    public function eliminarDocumentoAdicional($nombre) {
        return Storage::delete();
    }
}
