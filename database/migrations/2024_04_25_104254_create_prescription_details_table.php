<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->text('patient_problem')->nullable();
            $table->text('doctor_investigation')->nullable();
            $table->text('doctor_findings')->nullable();
            $table->text('doctor_lifestyle_advice')->nullable();
            $table->text('doctor_diet_advice')->nullable();
            $table->text('doctor_food_advice')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('prescription_id')->references('id')->on('prescriptions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('modified_by')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_details');
    }
}
