<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_assistants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_profile_id');
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('active_status')->default(true);
            $table->date('date_joining')->nullable();
            $table->date('date_leaving')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade');
            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->onDelete('set null');
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('set null');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('doctor_assistants');
    }
}
