<?php

use Illuminate\Database\Seeder;
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

        Avatar::truncate();
        Position::truncate();
        Employee::truncate();

        $positions = [
            'Президент',
            'Руководитель отдела',
            'Заместитель руководителя отдела',
            'Менеджер',
            'Программист',
            'Стажер'
        ];
        $employeesQuantityByPosition = [
            1, 5, 50, 500, 5000, 50000
        ];
        foreach ($positions as $position) {
            Position::create(["name" => $position]);
        }

        foreach ($employeesQuantityByPosition as $key => $quantity) {
            if ($key === 0) {//корневой сотрудник не имеющий начальства
                factory(Employee::class, 'root', $quantity)->create();
            }
            factory(Employee::class, $quantity)->create();
        }
    }
}
