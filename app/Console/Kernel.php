<?php

namespace App\Console;

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
        RegistroFaltasSemanalAuxiliar::class
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