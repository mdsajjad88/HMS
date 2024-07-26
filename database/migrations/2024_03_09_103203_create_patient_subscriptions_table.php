<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->dateTime('subscript_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->integer('used_consultancy')->default(0);
            $table->double('final_total', 8, 2)->default(0.00);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->decimal('minimum_payment_to_avail_service', 10, 2)->nullable();
            $table->unsignedInteger('maximum_installment_allows')->default(0);
            $table->unsignedInteger('maximum_service_in_each_installment')->default(0);
            $table->text('opinions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('patient_user_id')->references('id')->on('patient_profiles')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
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
        Schema::dropIfExists('patient_subscriptions');
    }
}
