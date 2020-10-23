<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAsistenciaSemanalRequest extends FormRequest
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
        $reglas = [];
        foreach ($this->request->get('asistencias') as $key => $val) {
            $reglas['asistencias.'.$key.'.horario_clase_id'] = 'required';
            $reglas['asistencias.'.$key.'.actividad_realizada'] = 'nullable';
            $reglas['asistencias.'.$key.'.observaciones'] = 'nullable';
            $reglas['asistencias.'.$key.'.indicador_verificable'] = 'nullable';
            $reglas['asistencias.'.$key.'.asistencia'] = 'required';
            $reglas['asistencias.'.$key.'.fecha'] = 'required';
            if($val['asistencia'] == "false")
                $reglas['asistencias.'.$key.'.permiso'] = 'required';
        }       
        return $reglas;
    }
}
