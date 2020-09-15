<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id'   =>  function() {
            return factory(\App\User::class)->create()->id;
        },
        'question_id'=> function () {
            return factory(\App\Question::class)->create()->id;
        },
        'content'   =>  $faker->text
    ];
});
