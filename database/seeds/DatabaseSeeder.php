<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use App\Avatar;
use App\Position;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    private const POSITIONS_LIST = [//список должностей и их количество
        'Президент' => 1,
        'Руководитель отдела' => 5,
        'Заместитель руководителя отдела' => 50,
        'Менеджер' => 500,
        'Программист' => 5000,
        'Стажер' => 50000
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Avatar::truncate();
        Position::truncate();
        Employee::truncate();

        User::flushEventListeners();

        factory(User::class, 'admin')->create();
        factory(User::class, 10)->create();

        $avatarPath = Storage::disk('avatars')->getAdapter()->getPathPrefix();
        if(File::exists($avatarPath)) {
            File::cleanDirectory($avatarPath);
        }else{
            File::makeDirectory($avatarPath);
        }


        $positionsIDs = [];//массив id должностей с требуемым количеством

        foreach (self::POSITIONS_LIST as $position => $count) {
            $currentPositionID = Position::create(["name" => $position])->id;
            $positionsIDs[$currentPositionID] = $count;
        }

        //для правдоподобности данных сначала заполняются более высокие должности.
        //иначе может выйти, что "президент" является подчиненным у "стажера"
        foreach ($positionsIDs as $positionID => $count) {
            factory(Employee::class, $count)->create(['position_id' => $positionID]);
        }
    }
}
