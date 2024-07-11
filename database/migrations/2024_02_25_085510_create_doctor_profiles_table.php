<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->string('bmdc_number')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('token_name')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nid')->nullable();
            $table->text('description')->nullable();
            $table->string('designation')->nullable();
            $table->text('medical_academic_summary')->nullable();
            $table->string('specialist')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_natural_certified')->default(false);
            $table->boolean('is_allopathic_certified')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamp('modified')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_dir')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->string('consultant_type')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('doctor_profiles');
    }
}
