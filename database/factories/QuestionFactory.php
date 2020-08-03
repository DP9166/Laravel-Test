<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\User;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id'   =>  function () {
            return factory(User::class)->create();
        },
        'title'     =>  $faker->sentence,
        'content'   =>  $faker->text
    ];
});
