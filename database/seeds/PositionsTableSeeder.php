<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Position::truncate();
        $positions = ['Президент', 'Руководитель отдела', 'Заместитель руководителя отдела', 'Менеджер', 'Программист', 'Стажер'];
        foreach ($positions as $position) {
            Position::create(["name" => $position]);
        }

    }
}
