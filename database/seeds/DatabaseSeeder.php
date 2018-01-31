<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Employee;
use App\Avatar;
use App\Position;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $faker = Faker::create("ru_RU");

        Avatar::truncate();
        Position::truncate();
        Employee::truncate();

        $employeesQuantity = 5;
        $avatarsQuantity = $employeesQuantity;

        $positions = [
            'Президент',
            'Руководитель отдела',
            'Заместитель руководителя отдела',
            'Менеджер',
            'Программист',
            'Стажер'
        ];
        foreach ($positions as $position) {
            Position::create(["name" => $position]);
        }

        //factory(Avatar::class, $avatarsQuantity)->create()->each(function ($avatar) {
        //    $avatar->createThumbnail();
        //});

        factory(Employee::class, $employeesQuantity)->create();
    }
}
