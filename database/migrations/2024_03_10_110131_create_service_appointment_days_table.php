<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB ;
class CreateServiceAppointmentDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_appointment_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->string('business_day_number', 10)->comment('sunday=1');
            $table->tinyInteger('business_day_type')->comment('weekend');
            $table->json('business_operating_hours')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->tinyInteger('active_status');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_appointment_days');
    }
}
