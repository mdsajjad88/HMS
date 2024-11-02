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
        Schema::create('report_and_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_report_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->timestamps();
            $table->foreign('review_report_id')->references('id')->on('review_reports')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_and_comments');
    }
};
