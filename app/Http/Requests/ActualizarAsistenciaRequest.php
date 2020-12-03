<?php

namespace App\Http\Requests;

use App\HorarioClase;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\PersonalAcademicoController;

class ActualizarAsistenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $val = $this->all();
        $reglas = [];
        $reglas['asistencia'] = 'required';
        if ($val['asistencia'] == "false") {
            $reglas['permiso'] = 'nullable';
            if (array_key_exists('permiso', $val)) {
                $reglas['documento_adicional'] = 'nullable';
                $reglas['observaciones'] = 'nullable|max:200';
            }
        } else {
            $reglas['actividad_realizada'] = 'required|min:5|max:150';
            $reglas['observaciones'] = 'nullable|max:200';
            $reglas['indicador_verificable'] = 'nullable';
        }
        return $reglas;
    }
}