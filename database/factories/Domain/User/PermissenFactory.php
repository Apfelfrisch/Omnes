<?php

use Faker\Generator;
use App\Domain\User\Permission;

$factory->define(Permission::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'lable' => $faker->sentence,
    ];
});
