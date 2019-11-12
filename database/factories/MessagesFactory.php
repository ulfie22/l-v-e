<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Messages;
use Faker\Generator as Faker;

$factory->define(Messages::class, function (Faker $faker) {
    return [
        'user' => $faker->word,
        'body' => $faker->,
        'type' => $faker->word,
    ];
});
