<?php
/**
 * Eloquent Factory
 *
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Models\Application;
use Faker\Generator as Faker;

$factory->define(
    Application::class,
    function (Faker $faker) {
        return [
            'quantity' => $faker->randomNumber(2)
        ];
    }
);
