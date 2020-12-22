<?php

namespace App\Providers;

use App\Http\Controllers\PersonalAcademicoController;
use App\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::if('esJefeDepartamento', function($unidad_id){
            return User::esJefeDepartamento($unidad_id);
        });
        Blade::if('aproboParte', function($parteId){
            return User::aproboParte($parteId);
        });
        Blade::if('esEncargadoFac', function($facultad_id){
            return User::esEncargadoFac($facultad_id);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/La_Paz');
    }
}