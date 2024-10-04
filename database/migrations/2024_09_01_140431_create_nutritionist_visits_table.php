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
        Schema::create('nutritionist_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('review_report_id')->nullable();
            $table->unsignedBigInteger('nutritionist_user_id')->nullable();
            $table->string('type_of_consultant')->nullable();
            $table->string('diet_plan_status')->nullable();
            $table->string('challanced_faced')->nullable();
            $table->string('diet_plan_satisfaction')->nullable();
            $table->string('treatment_satisfaction')->nullable();
            $table->string('suggetion_for_improvement')->nullable();
            $table->string('visit_duration')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('review_report_id')->references('id')->on('review_reports')->onDelete('cascade');
            $table->foreign('nutritionist_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritionist_visits');
    }
};
