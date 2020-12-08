<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAsistenciaLaboRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // modificar cuando se tenga el inicio de sesion
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
            $reglas['asistencias.' . $key . '.horario_clase_id'] = 'required';
            $reglas['asistencias.' . $key . '.asistencia'] = 'required';
            if ($val['asistencia'] == "false") {
                $reglas['asistencias.' . $key . '.permiso'] = 'nullable';
                if (array_key_exists('permiso', $val)) {
                    $reglas['asistencias.' . $key . '.documento_adicional'] = 'nullable|mimes:pdf,doc,docx,jpg,png,bmp,gif,svg,webp';
                    $reglas['asistencias.' . $key . '.observaciones'] = 'nullable|max:200';
                }
            } else {
                $reglas['asistencias.' . $key . '.actividad_realizada'] = 'required|min:5|max:150';
                $reglas['asistencias.' . $key . '.observaciones'] = 'nullable|max:200';
            }
        }
        return $reglas;
    }

    // nombrar atributos para mostrar errores
    public function attributes()
    {
        $nombres = [];
        foreach ($this->request->get('asistencias') as $key => $val) {
            $nombres['asistencias.' . $key . '.horario_clase_id'] = 'horario_clase_id';
            $nombres['asistencias.' . $key . '.asistencia'] = 'asistencia';
            $nombres['asistencias.' . $key . '.fecha'] = 'fecha';
            $nombres['asistencias.' . $key . '.permiso'] = 'permiso';
            $nombres['asistencias.' . $key . '.actividad_realizada'] = 'actividad_realizada';
            $nombres['asistencias.' . $key . '.observaciones'] = 'observaciones';
        }
        return $nombres;
    }
}