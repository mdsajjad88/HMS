<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAppointmentSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id');
            $table->integer('calendar_year');
            $table->integer('calendar_month');
            $table->integer('calendar_day');
            $table->date('calendar_date')->nullable();
            $table->json('slots')->nullable();
            $table->integer('slot_capacity')->default(0);
            $table->integer('slot_count')->default(0);
            $table->integer('slot_reserved')->default(0);
            $table->integer('slot_booked')->default(0);
            $table->tinyInteger('slot_active')->default(1);
            $table->string('remarks', 500)->nullable();
            $table->dateTime('created')->nullable();
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->integer('slot_duration')->default(0);
            $table->unsignedBigInteger('service_appointment_day_id')->nullable();

            // Foreign key constraint
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_appointment_day_id')->references('id')->on('service_appointment_days')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_appointment_slots');
    }
}
