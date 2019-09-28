<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ItemTemplate;
use Faker\Generator as Faker;

$factory->define(ItemTemplate::class, function (Faker $faker) {
    return [
        'urgency'      => 0,
        'description'  => $faker->sentence,
        'due_interval' => 0,
        'due_unit'     => '',
        'template_id'  => factory('App\Template')->create()->id
    ];
});
