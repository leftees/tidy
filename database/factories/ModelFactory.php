<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Tidy\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('qwerty'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(Tidy\Account::class, function (Faker\Generator $faker) {
   return [
       'name' => $faker->text(100),
       'address' => $faker->address,
       'description' => $faker->realText(500)
   ];
});