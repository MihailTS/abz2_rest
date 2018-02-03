<?php

use Faker\Generator as Faker;
use App\Avatar as Avatar;

$factory->define(Avatar::class, function (Faker $faker) {
    $filepath = Avatar::AVATAR_PATH;

    if (!File::exists($filepath)) {
        File::makeDirectory($filepath);
    }

    return [
        'path' => $faker->image($filepath, 400, 300)
    ];
});

