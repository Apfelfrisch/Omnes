<?php

use Faker\Generator;
use App\Domain\League\League;
use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;
use App\Domain\Activity\Activity;

$factory->define(Activity::class, function (Generator $faker) {
    return [
        'league_id' => function() {
            return factory(League::class)->create()->id;       
        },
        'adress_id' => function() {
            return factory(Adress::class)->create()->id;       
        },
        'contact_id' => function() {
            return factory(Contact::class)->create()->id;
        },
        'description' => $faker->sentence,
    ];
});
