<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXAcademicCourseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_academic_course_types', function (Blueprint $table) {
            $table->id();
            $table->string('course_type_code', 10)->unique();
            $table->string('course_type', 255);
            $table->integer('created_by')->nullable();
            $table->datetime('created')->nullable();
            $table->integer('modified_by')->nullable();
            $table->datetime('modified')->nullable();
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
        Schema::dropIfExists('x_academic_course_types');
    }
}
