<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    $number = rand(100,300);
    $banner = "https://i.picsum.photos/id/{$number}/1280/720.jpg";
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->paragraph(),
        'banner' => $banner
    ];
});
