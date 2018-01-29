<?php

use Faker\Generator as Faker;

$factory->define(App\Avatar::class, function (Faker $faker) {
    $filepath = 'public/storage/avatars';

    if (!File::exists($filepath)) {
        File::makeDirectory($filepath);
    }

    return [
        'path' => $faker->image($filepath, 400, 300)
    ];
});
