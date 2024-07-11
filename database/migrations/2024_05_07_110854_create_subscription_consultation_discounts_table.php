<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionConsultationDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_consultation_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->enum('discount_type', ['Percentage', 'Fixed']);
            $table->unsignedInteger('discount');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate(); // Use CURRENT_TIMESTAMP for 'modified' column

            // Foreign key constraints
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_consultation_discounts');
    }
}
