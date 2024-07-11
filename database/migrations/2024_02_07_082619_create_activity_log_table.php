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
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id');
            $table->unsignedBigInteger('patient_profile_id');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedBigInteger('helped_by')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->timestamps();

            // Foreign key constraints
             $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
             $table->foreign('patient_profile_id')->references('id')->on('patient_profiles')->onDelete('cascade');
             $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
             $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
             $table->foreign('helped_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
