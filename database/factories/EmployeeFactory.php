<?php

use Faker\Generator as Faker;
use App\Position;
use App\Employee;
use App\Avatar;

$factory->define(App\Employee::class, function (Faker $faker) use ($factory) {
    $position = Position::all()->random();
    $headArray = Employee::all()->pluck("id")->toArray();

    $avatar = factory(Avatar::class)->create();
    $avatar->each(function ($avatar) {
        $avatar->createThumbnail();
    });
    return [
        'name' => $faker->name,
        'employmentDate' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
        'salary' => $faker->randomFloat(2, 1000, 1000000),
        'position_id' => is_null($position) ? null : $position->id,
        'head_id' => $faker->randomElement($headArray),
        'avatar_id' => $avatar->id
    ];
});
