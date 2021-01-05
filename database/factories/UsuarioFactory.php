<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        'codSis' => $faker->randomNumber(9),
        'nombre' => $faker->name(),
        'contrasenia' => Str::random(8),
        'correo_electronico' => $faker->unique()->safeEmail
    ];
});
