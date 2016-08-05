<?php

use Faker\Generator;
use App\Service\Acl\Role\Role;

$factory->define(Role::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'lable' => $faker->sentence,
    ];
});
