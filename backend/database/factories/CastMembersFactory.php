<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CastMembers;
use Faker\Generator as Faker;

$factory->define(CastMembers::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'type' => array_rand([CastMembers::TYPE_DIRECTOR, CastMembers::TYPE_ACTOR])
    ];
});
