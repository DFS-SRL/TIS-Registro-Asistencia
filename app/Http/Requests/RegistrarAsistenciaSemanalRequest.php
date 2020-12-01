<?php

namespace App\Http\Requests;

use App\HorarioClase;
use App\Http\Controllers\PersonalAcademicoController;
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
            $reglas['asistencias.' . $key . '.horario_clase_id'] = 'required';
            $reglas['asistencias.' . $key . '.asistencia'] = 'required';
            $reglas['asistencias.' . $key . '.fecha'] = 'required';
            if ($val['asistencia'] == "false") {
                    $reglas['asistencias.' . $key . '.permiso'] = 'required';
                $reglas['asistencias.' . $key . '.documento_adicional'] = 'nullable';
                $reglas['asistencias.' . $key . '.observaciones'] = 'nullable|max:200';
            }
            else {
                $reglas['asistencias.' . $key . '.actividad_realizada'] = 'required|min:5|max:150';
                $reglas['asistencias.' . $key . '.observaciones'] = 'nullable|max:200';
                $horario = HorarioClase::find($val['horario_clase_id']);
                if (PersonalAcademicoController::esAuxDoc($horario->asignado_codSis, $horario->unidad_id))
                    $reglas['asistencias.' . $key . '.indicador_verificable'] = 'required';
                else
                    $reglas['asistencias.' . $key . '.indicador_verificable'] = 'nullable';
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
            $nombres['asistencias.' . $key . '.indicador_verificable'] = 'indicador_verificable';
        }
        return $nombres;
    }
}