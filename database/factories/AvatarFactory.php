<?php

use Faker\Generator as Faker;
use App\Avatar as Avatar;
use Illuminate\Support\Facades\Storage;

$factory->define(Avatar::class, function (Faker $faker) {
    $avatarFolder = Storage::disk('avatars')->getAdapter()->getPathPrefix();
    return [
        'path' => $faker->image($avatarFolder, 400, 300, null, false)

    ];
});

