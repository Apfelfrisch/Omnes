<?php

use Faker\Generator;
use App\Domain\Activity\Activity;
use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;

$factory->define(Activity::class, function (Generator $faker) {
    return [
        'adress_id' => function() {
            return factory(Adress::class)->create()->id;       
        },
        'contact_id' => function() {
            return factory(Contact::class)->create()->id;
        },
        'description' => $faker->sentence,
    ];
});
