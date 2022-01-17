<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ecard;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Ecard::class, function (Faker $faker) {
    static $i = 1;
    return [
        'private' => $faker->boolean,
        'filename' => 'LAVENDERFIELDS01.jpg',
        'thumbnail' => 'LAVENDERFIELDS01.jpg',
        'caption' => $faker->sentence,
        'detail' => $faker->text,
        'video' => 'LAVENDERFIELDS01.jpg',
    ];
});
