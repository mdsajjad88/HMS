<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationBedAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_bed_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_profile_id');
            $table->unsignedBigInteger('x_first_division_code_id')->nullable();
            $table->unsignedBigInteger('x_second_division_code_id')->nullable();
            $table->integer('sanction_bed_count');
            $table->integer('current_bed_count');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            // Foreign key constraints (if needed)
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('x_first_division_code_id')->references('id')->on('x_first_division_codes')->onDelete('cascade');
            $table->foreign('x_second_division_code_id')->references('id')->on('x_second_division_codes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_bed_assignments');
    }
}
