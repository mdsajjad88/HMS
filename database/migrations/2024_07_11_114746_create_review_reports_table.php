<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id');
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_medical_test_id')->nullable();//hide hobe
            $table->unsignedBigInteger('prescribed_medicine_id')->nullable();//hide hobe
            $table->unsignedBigInteger('prescription_therapie_id')->nullable();//hide hobe
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('no_of_visite')->nullable();
            $table->date('last_visited_date')->nullable();
            $table->integer('bd_medicine')->nullable();
            $table->integer('us_medicine')->nullable();
            $table->integer('no_of_medicine')->nullable();
            $table->integer('no_of_test')->nullable();
            $table->integer('no_of_ozone_therapy')->nullable();
            $table->integer('no_of_hijama_therapy')->nullable();
            $table->integer('on_of_acupuncture')->nullable();
            $table->integer('no_of_sauna')->nullable();
            $table->integer('no_of_phototherapy')->nullable();
            $table->integer('no_of_physiotherapy')->nullable();
            $table->integer('no_of_coffee_anema')->nullable();
            $table->integer('no_of_others')->nullable();
            $table->integer('no_of_life_style_food')->nullable();
            $table->unsignedBigInteger('problem_id')->nullable();
            $table->string('physical_improvement')->default(false);
            $table->string('comment', 255)->nullable();
            $table->string('custom_column1', 255)->nullable();
            $table->string('custom_column2', 255)->nullable();
            $table->string('custom_column3', 255)->nullable();
            $table->string('custom_column4', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();



            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_medical_test_id')->references('id')->on('patient_medical_tests')->onDelete('cascade');
            $table->foreign('prescribed_medicine_id')->references('id')->on('prescribed_medicines')->onDelete('cascade');
            $table->foreign('prescription_therapie_id')->references('id')->on('prescription_therapies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reports');
    }
};
