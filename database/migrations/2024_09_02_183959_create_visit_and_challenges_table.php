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
        Schema::create('visit_and_challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nutritionist_visit_id')->nullable();
            $table->unsignedBigInteger('challenge_id')->nullable();
            $table->unsignedBigInteger('nutritionist_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->timestamps();
            $table->foreign('nutritionist_visit_id')->references('id')->on('nutritionist_visits')->onDelete('cascade');
            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('cascade');
            $table->foreign('nutritionist_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_and_challenges');
    }
};
