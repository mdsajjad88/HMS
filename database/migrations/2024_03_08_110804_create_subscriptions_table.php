<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedInteger('valid_in_days');
            $table->double('price', 8, 2);
            $table->tinyInteger('consultations');
            $table->tinyInteger('status')->default(0);
            $table->decimal('minimum_payment_to_avail_service', 10, 2)->nullable();
            $table->unsignedInteger('maximum_installment_allows')->default(0);
            $table->unsignedInteger('maximum_service_in_each_installment')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate(); // Use CURRENT_TIMESTAMP for 'modified' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
