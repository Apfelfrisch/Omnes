<?php

use Faker\Generator;
use App\Domain\Contact\Contact;

$factory->define(Contact::class, function (Generator $faker) {
    return [
        'fax' => $faker->phoneNumber,
        'mail' => $faker->email,
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'twitter' => $faker->url,
        'facebook' => $faker->url,
    ];
});
