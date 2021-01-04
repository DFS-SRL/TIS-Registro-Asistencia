<?php

namespace App\Console;

use App\Console\Commands\NotificacionPlanillasDiarias;
use App\Console\Commands\NotificacionPlanillasSemanales;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\RegistroFaltasDiario;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RegistroFaltasSemanalDocente;
use App\Console\Commands\RegistroFaltasSemanalAuxiliar;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RegistroFaltasDiario::class,
        RegistroFaltasSemanalDocente::class,
        RegistroFaltasSemanalAuxiliar::class,
        NotificacionPlanillasSemanales::class,
        NotificacionPlanillasDiarias::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('faltas:diario')
                    ->dailyAt('00:01')
                    ->timezone('America/La_Paz');

        $schedule->command('faltas:semanaldocente')
                    ->sundays()
                    ->at('00:01')
                    ->timezone('America/La_Paz');

        $schedule->command('faltas:semanalauxiliar')
                    ->sundays()
                    ->at('00:01')
                    ->timezone('America/La_Paz');

        $schedule->command('notificacion:planillas-semanales')
                    ->sundays()
                    ->at('20:49')
                    ->timezone('America/La_Paz');

        $schedule->command('notificacion:planillas-diarias')
                    ->dailyAt('19:00')
                    ->timezone('America/La_Paz');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}