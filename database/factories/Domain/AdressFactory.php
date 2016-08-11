<?php

use Faker\Generator;
use App\Domain\Adress\Adress;

$factory->define(Adress::class, function (Generator $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->streetSuffix,
        'zip' => $faker->postcode,
        'city' => $faker->city,
    ];
});
