<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ChecklistTemplate;
use Faker\Generator as Faker;

$factory->define(ChecklistTemplate::class, function (Faker $faker) {
    return [
        'description'  => $faker->sentence,
        'due_interval' => 0,
        'due_unit'     => '',
        'template_id'  => factory('App\Template')->create()->id
    ];
});
