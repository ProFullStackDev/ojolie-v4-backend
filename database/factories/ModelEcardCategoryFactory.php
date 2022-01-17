<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EcardCategory;
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

$factory->define(EcardCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'header_image' => 'https://www.ojolie.com/cards/resource/picture/All/new_year_ecards_header.jpg',
        'header_color' => $faker->hexcolor,
        'header_descripion' => $faker->text,
        'page_title' => $faker->word,
        'page_description' => $faker->text,
        'meta_keyword' => $faker->word,
    ];
});
