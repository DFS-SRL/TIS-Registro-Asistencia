<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAsistenciaDocenteRequest extends FormRequest
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
            $reglas['asistencias.'.$key.'.actividad_realizada'] = 'required';
            $reglas['asistencias.'.$key.'.observaciones'] = 'required';
            $reglas['asistencias.'.$key.'.asistencia'] = 'required';
            if($val['asistencia'] == "false")
                $reglas['asistencias.'.$key.'.permiso'] = 'required';
        }       
        return $reglas;
    }
}
