<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Checklist;
use Faker\Generator as Faker;

$factory->define(Checklist::class, function (Faker $faker) {
    return [
        'object_domain' => $faker->sentence,
        'object_id'     => $faker->randomDigit,
        'description'   => $faker->sentence,
        'is_completed'  => 0,
        'completed_at'  => $faker->date('Y-m-d'),
        'updated_by'    => $faker->name,
        'due'           => null,
        'urgency'       => null
    ];
});
