<?php

use Faker\Generator;
use App\Domain\Coordinator;

$factory->define(Coordinator::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
    ];
});
