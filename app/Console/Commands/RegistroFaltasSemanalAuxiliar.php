<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\HorarioClase;
use App\Asistencia;

class RegistroFaltasSemanalAuxiliar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faltas:semanalauxiliar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // obtener horarios con rol 2 (auxiliar de docencia)
        $horarios = HorarioClase::where('Horario_clase.rol_id', '=', 2)
                            ->get()->groupBy('dia');
        
        // fecha por dias de la semana
        $fechaPorDia = getFechasDeSemanaEnFecha("yesterday");      

        // buscar horarios que no fueron registrados
        foreach ($horarios as $horariosEnDia) {
            foreach ($horariosEnDia as $falta) {
                $asistencia = Asistencia::where('horario_clase_id', '=', $falta->id)
                ->where('fecha', '=', $fechaPorDia[compararDias($falta->dia, "LUNES")])
                ->get();
                if ($asistencia->isEmpty()) {
                    Asistencia::create([
                        'horario_clase_id' => $falta->id,
                        'fecha' => $fechaPorDia[compararDias($falta->dia, "LUNES")],
                        'nivel' => 2,
                        'usuario_codSis' => $falta->asignado_codSis,
                        'materia_id' => $falta->materia_id,
                        'grupo_id' => $falta->grupo_id,
                        'unidad_id' => $falta->unidad_id,
                        'asistencia' => false
                    ]);
                }
            }
        }

        echo "se registraron faltas de auxiliares \n";
    }
}
