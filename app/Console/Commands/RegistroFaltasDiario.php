<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Console\Command;

class RegistroFaltasDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faltas:diario';

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
        if(getDia() != "LUNES")
        {
            $ayer = new Carbon('yesterday');
            // obtener horarios con rol 1
            $horarios = HorarioClase::where('dia', '=', traducirDia1($ayer->dayOfWeek))
                                ->where('Horario_clase.rol_id', '=', 1)
                                ->get();
            // buscar horarios que no fueron registrados
            foreach ($horarios as $key => $falta) {
                if(Asistencia::where('fecha', '=', $ayer->toDateString())
                            ->where('horario_clase_id', '=', $falta->id)
                            ->get()->isEmpty())
                    Asistencia::create([
                        'horario_clase_id' => $falta->id,
                        'fecha' => $ayer->toDateString(),
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
}