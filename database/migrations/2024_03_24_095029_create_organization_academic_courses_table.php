<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationAcademicCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_academic_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('x_first_division_code_id')->nullable();
            $table->unsignedBigInteger('x_second_division_code_id')->nullable();
            $table->unsignedBigInteger('x_academic_course_type_id')->nullable();
            $table->string('course_name', 255);
            $table->string('course_duration', 64)->nullable();
            $table->string('course_discipline', 255)->nullable();
            $table->integer('sanction_seats_gov');
            $table->integer('sanction_seats_nongov');
            $table->integer('sanction_seats_foreign');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('x_first_division_code_id')->references('id')->on('x_first_division_codes')->onDelete('cascade');
            $table->foreign('x_second_division_code_id')->references('id')->on('x_second_division_codes')->onDelete('cascade');
            $table->foreign('x_academic_course_type_id')->references('id')->on('x_academic_course_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_academic_courses');
    }
}
