<?php

namespace App\Console\Commands;

use App\Asistencia;
use App\HorarioClase;
use App\Mail\NotifiacionPlanillaDiaria;
use App\Notificaciones;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificacionPlanillasDiarias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:planillas-diarias';

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
        if(getDia() != "DOMINGO")
        {
            $hoy = new Carbon();
            // obtener horarios con rol 1
            $horarios = HorarioClase::where('dia', '=', traducirDia1($hoy->dayOfWeek))
                                ->where('Horario_clase.rol_id', '=', 1)
                                ->get();
            
            $auxiliares = [];

            // buscar horarios que no fueron registrados
            foreach ($horarios as $key => $falta) {
                if(Asistencia::where('fecha', '=', $hoy->toDateString())
                            ->where('horario_clase_id', '=', $falta->id)
                            ->get()->isEmpty())
                    array_push($auxiliares, $falta->asignado);
            }

            $auxiliares = array_unique($auxiliares);

            foreach($auxiliares as $auxi){
                // if($auxi->codSis === 3){
                    Mail::to($auxi->correo_electronico)->send(new NotifiacionPlanillaDiaria($auxi));
                    Notificaciones::create([
                        'user_id' => $auxi->codSis,
                        'text' => 'Llena tus planillas semanales de auxiliatura de laboratorio.',
                        'link' => route('planillas.diaria.obtener', $auxi->codSis)
                    ]);
                // }
            }
        }
    }
}
