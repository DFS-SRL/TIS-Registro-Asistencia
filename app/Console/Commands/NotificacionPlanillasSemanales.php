<?php

namespace App\Console\Commands;

use App\Asistencia;
use App\HorarioClase;
use App\Mail\NotificacionPlanillaSemanal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificacionPlanillasSemanales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:planillas-semanales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificar personal academico para llenado de planillas semanales';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->notificar(2);
        $this->notificar(3);
    }

    private function notificar($rol){
        $horarios = HorarioClase::where('Horario_clase.rol_id', '=', $rol)
                            ->get()->groupBy('dia');
        
        // fecha por dias de la semana
        $fechaPorDia = getFechasDeSemanaEnFecha("today");

        $auxiliares = [];

        // buscar horarios que no fueron registrados
        foreach ($horarios as $horariosEnDia) {
            foreach ($horariosEnDia as $falta) {
                $asistencia = Asistencia::where('horario_clase_id', '=', $falta->id)
                ->where('fecha', '=', $fechaPorDia[compararDias($falta->dia, "LUNES")])
                ->get();
                $codSis = $horariosEnDia[0]->asignado_codSis;
                if ($asistencia->isEmpty() && $codSis !== null) {
                    array_push($auxiliares, $horariosEnDia[0]->asignado);
                }
            }
        }
        $auxiliares = array_unique($auxiliares);

        $type = null;
        if($rol === 2){
            $type = 'auxdoc';
        }else{
            $type = 'docente';
        }

        foreach($auxiliares as $auxi){
            // if($auxi->codSis === 5){
                Mail::to($auxi->correo_electronico)->send(new NotificacionPlanillaSemanal($auxi, $type));
            // }
        }
    }
}
