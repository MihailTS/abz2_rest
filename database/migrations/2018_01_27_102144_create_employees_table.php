<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('employmentDate');
            $table->decimal('salary',8,2);
            $table->integer('head_id')->unsigned()->nullable();//президент компании может не иметь начальника
            $table->integer('position_id')->unsigned()->nullable();
            $table->integer('avatar_id')->unsigned()->nullable();

            $table->foreign('head_id')->references('id')->on('employees');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('SET NULL');
            $table->foreign('avatar_id')->references('id')->on('avatars')->onDelete('SET NULL');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
