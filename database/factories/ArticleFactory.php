<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker, $user_id) {
    return [
        'title' => $faker->title,
        'year' => $faker->year,
        'article_type' => $faker->text 
    ];
});
