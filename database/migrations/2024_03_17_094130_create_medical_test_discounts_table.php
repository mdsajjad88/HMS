<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalTestDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_test_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->longText('description')->nullable();
            $table->json('medical_test_id')->nullable();
            $table->integer('status')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('discount_type', 255)->nullable();
            $table->double('discount', 8, 2)->default(0);
            $table->tinyInteger('all_packages')->default(0);
            $table->tinyInteger('all_test')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints (if needed)
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_test_discounts');
    }
}
