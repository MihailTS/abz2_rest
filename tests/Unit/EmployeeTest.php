<?php

namespace Tests\Unit;

use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_IsHeadOf_DirectHead()
    {
        $rootEmployee = factory(Employee::class)->create();
        $firstLevelEmployee = factory(Employee::class)->create(['head_id' => ($rootEmployee->id)]);
        $this->assertTrue($rootEmployee->isHeadOf($firstLevelEmployee));
    }

    public function test_IsHeadOf_IndirectHead()
    {
        $rootEmployee = factory(Employee::class)->create();
        $firstLevelEmployee = factory(Employee::class)->create(['head_id' => ($rootEmployee->id)]);
        $secondLevelEmployee = factory(Employee::class)->create(['head_id' => $firstLevelEmployee->id]);
        $this->assertTrue($rootEmployee->isHeadOf($secondLevelEmployee));
    }


    public function test_IsHeadOf_NotHead()
    {
        $rootEmployee = factory(Employee::class)->create();
        $firstLevelEmployee = factory(Employee::class)->create(['head_id' => ($rootEmployee->id)]);
        $this->assertFalse($firstLevelEmployee->isHeadOf($rootEmployee));
    }

    public function test_changeHead_Normal()
    {
        $employeeSubordinate = factory(Employee::class)->create();
        $employeeNewHead = factory(Employee::class)->create();

        $employeeSubordinate->changeHead($employeeNewHead);

        $this->assertTrue($employeeSubordinate->head->id == $employeeNewHead->id);
    }

    /**
     * если новый начальник является подчиненным текущего сотрудника
     */
    public function test_changeHead_IfSubordinate()
    {
        $this->expectExceptionMessage('parent');

        $employeeSubordinate = factory(Employee::class)->create();
        $employeeNewHead = factory(Employee::class)->create(['head_id' => $employeeSubordinate->id]);

        $employeeSubordinate->changeHead($employeeNewHead);
    }
}
