<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'owner_id' => factory(App\User::class)->create()->id,
        'category_id' => 1,
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'thumbnail_img' => ''
    ];
});
