<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppointmentSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_chamber_id');
            $table->unsignedBigInteger('doctor_profile_id');
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('doctor_assistant_id')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->integer('calendar_year');
            $table->string('calendar_month', 20);
            $table->integer('calendar_day');
            $table->date('calendar_date');
            $table->json('slots')->nullable();
            $table->integer('slot_capacity')->default(0);
            $table->integer('slot_count')->default(0);
            $table->integer('slot_reserved')->default(0);
            $table->integer('slot_booked')->default(0);
            $table->boolean('slot_active')->default(true);
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->integer('slot_duration')->nullable();
            $table->unsignedBigInteger('doctor_appointment_day_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->onDelete('cascade');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade');
            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('doctor_assistant_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('doctor_appointment_day_id')->references('id')->on('doctor_appointment_days')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_appointment_slots');
    }
}
