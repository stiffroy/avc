<?php

use Faker\Generator as Faker;

/**
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(App\Entity\Client::class, function (Faker $faker) {
    return [
        'name' => str_random(8),
        'external_id' => str_random(5) . '-' . str_random(4) . '-' . rand(1, 10),
        'alive' => $faker->boolean,
        'heartbeat_at' => $faker->dateTime
    ];
});
