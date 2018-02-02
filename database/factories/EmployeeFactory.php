<?php

use Faker\Generator as Faker;
use App\Position;
use App\Head;
use App\Avatar;

$factory->define(App\Employee::class, function (Faker $faker) use ($factory) {
    $position = Position::inRandomOrder()->first();
    $head = Head::inRandomOrder()->first();

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
        'salary' => $faker->randomFloat(2, 1000, 1000000),
        'position_id' => $position->id,
        'head_id' => is_null($head) ?: $head->id,
        'avatar_id' => $hasAvatar ? $avatar->id : null,
    ];
});
