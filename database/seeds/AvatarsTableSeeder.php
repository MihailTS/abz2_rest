<?php

use Illuminate\Database\Seeder;
use App\Avatar;

class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Avatar::truncate();
        factory(Avatar::class, 200)->create()->each(function ($avatar) {
            $avatar->createThumbnail();
        });
    }
}
