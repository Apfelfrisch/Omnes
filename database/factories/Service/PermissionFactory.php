<?php

use Faker\Generator;
use App\Service\Acl\Permission\Permission;

$factory->define(Permission::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'lable' => $faker->sentence,
    ];
});
