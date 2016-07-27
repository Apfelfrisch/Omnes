<?php

use Faker\Generator;
use App\Domain\User\Role;

$factory->define(Role::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'lable' => $faker->sentence,
    ];
});
