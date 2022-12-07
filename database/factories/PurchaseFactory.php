<?php
/**
 * Eloquent Factory
 *
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Models\Purchase;
use Faker\Generator as Faker;

$factory->define(
    Purchase::class,
    function (Faker $faker) {
        return [
            'qty_purchased' => $faker->randomNumber(2),
            'price' => $faker->numberBetween(0, 500)
        ];
    }
);
