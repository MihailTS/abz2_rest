<?php

use Faker\Generator as Faker;
use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    $isVerified = $faker->boolean();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: bcrypt('secret'),
        'remember_token' => str_random(10),
        'isAdmin' => $faker->boolean(),
        'isVerified' => $isVerified,
        'verification_token' => $isVerified ? null : User::generateVerificationCode(),
    ];
});

//admin user
$factory->defineAs(User::class, 'admin', function (Faker $faker) {
    $isVerified = $faker->boolean();
    return [
        'name' => 'admin',
        'email' => 'tseluiko.m@gmail.com',
        'password' => 'password',
        'remember_token' => str_random(10),
        'isAdmin' => true,
        'isVerified' => $isVerified,
        'verification_token' => $isVerified ? null : User::generateVerificationCode(),
    ];
});