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
        Schema::create('nutritionists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
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
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritionists');
    }
};
