<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentsRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('student_number')->nullable();
            $table->integer('gender')->default(0);
            $table->string('auto_number')->nullable();
            $table->integer('status')->default(0);
            $table->integer('row_line')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('created_by');
            $table->datetime('time_in');
            $table->datetime('time_out');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
