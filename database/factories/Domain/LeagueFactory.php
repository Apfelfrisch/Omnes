<?php

use Faker\Generator;
use App\Domain\League\League;
use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;

$factory->define(League::class, function (Generator $faker) {
    return [
        'adress_id' => function() {
            return factory(Adress::class)->create()->id;       
        },
        'contact_id' => function() {
            return factory(Contact::class)->create()->id;
        },
        'name' => $faker->company,
        'logo' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
