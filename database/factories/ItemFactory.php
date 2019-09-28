<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'description'  => $faker->sentence,
        'is_completed' => 0,
        'task_id'      => 1,
        'completed_at' => $faker->date('Y-m-d'),
        'due'          => null,
        'urgency'      => null,
        'updated_by'   => $faker->name,
        'assigned_id'  => 1,
        'checklist_id' => factory('App\Checklist')->create()->id
    ];
});
