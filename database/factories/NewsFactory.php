<?php

/** @var Factory $factory */

use App\Entities\News;
use Carbon\Carbon;
use Faker\Generator as Faker;
use LaravelDoctrine\ORM\Testing\Factory;

/*
|--------------------------------------------------------------------------
| Models Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(News::class, function(Faker $faker) {
    $date = $faker->randomElement([Carbon::now()->subDays(40), Carbon::now()]);

    return [
        'title' => $faker->text(100),
        'text' => $faker->text(10000),
        'created_at' => $date,
        'updated_at' => $date
    ];
});
