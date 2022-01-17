<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ecard;
use App\EcardCategory;
use App\EcardToCategory;
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

$factory->define(EcardToCategory::class, function (Faker $faker) {
    
    return [
        'ecard_id' => $faker->unique()->numberBetween(1, Ecard::count()),
        'ecard_category_id' => $faker->numberBetween(1,EcardCategory::count()),
        'type' => $faker->randomDigit,
    ];
});
