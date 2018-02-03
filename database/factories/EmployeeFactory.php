<?php

use Faker\Generator as Faker;
use App\Position;
use App\Avatar;
use App\Employee;

$factory->define(Employee::class, function (Faker $faker) use ($factory) {
    $position = Position::inRandomOrder()->first();
    $head = Employee::inRandomOrder()->first();
    $hasHead = !is_null($head);

    $avatar = null;
    $hasAvatar = $faker->boolean();//аватар установлен для половины пользователей
    if ($hasAvatar) {
        $avatar = factory(Avatar::class)->create();
        $avatar->each(function ($avatar) {
            $avatar->createThumbnail();
        });
    }
    return [
        'name' => $faker->name,
        'employmentDate' => $faker->dateTimeBetween('-10 years'),
        'salary' => $faker->randomFloat(2, 1000, 1000000),
        'position_id' => $position->id,
        'head_id' => $hasHead ? $head->id : null,
        'avatar_id' => $hasAvatar ? $avatar->id : null,
    ];
});

//корневой сотрудник без начальства
$factory->defineAs(App\Employee::class, 'root', function (Faker $faker) use ($factory) {
    $position = Position::first();

    $avatar = null;
    $hasAvatar = $faker->boolean();
    if ($hasAvatar) {
        $avatar = factory(Avatar::class)->create();
        $avatar->each(function ($avatar) {
            $avatar->createThumbnail();
        });
    }
    return [
        'name' => $faker->name,
        'employmentDate' => $faker->dateTimeBetween('-10 years'),
        'salary' => $faker->randomFloat(2, 100000, 1000000),
        'position_id' => $position->id,
        'head_id' => null,
        'avatar_id' => $hasAvatar ? $avatar->id : null,
    ];
});