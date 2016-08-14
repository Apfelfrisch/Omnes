<?php

use Faker\Generator;
use App\Domain\League\League;
use App\Service\Acl\User\User;
use App\Service\Acl\Role\Role;
use App\Service\Acl\UserRole\UserRole;

$factory->define(UserRole::class, function (Generator $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;       
        },
        'role_id' => function() {
            return factory(Role::class)->create()->id;       
        },
        'league_id' => function() {
            return factory(League::class)->create()->id;       
        }
    ];
});
