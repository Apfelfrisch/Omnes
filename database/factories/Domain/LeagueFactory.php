<?php

use Faker\Generator;
use App\Domain\League\League;

$factory->define(League::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
    ];
});
