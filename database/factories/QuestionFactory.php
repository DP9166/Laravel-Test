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

$factory->state(Question::class,'published',function ($faker) {
    return [
        'published_at' => \Carbon\Carbon::parse('-1 week')
    ];
});

$factory->state(Question::class,'unpublished',function ($faker) {
    return [
        'published_at' => null
    ];
});
