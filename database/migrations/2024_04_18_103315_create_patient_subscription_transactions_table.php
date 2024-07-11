<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSubscriptionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_subscription_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('patient_subscription_id')->nullable();
            $table->tinyInteger('t_type')->comment('1:credit,2:deduct');
            $table->double('t_amount', 8, 2)->default(0.00);
            $table->double('discount_amount', 8, 2)->default(0.00);
            $table->string('t_txid', 50);
            $table->text('t_log')->nullable();
            $table->tinyInteger('t_status')->default(0);
            $table->string('t_media', 100)->nullable()->comment('bkash,rocket etc');
            $table->text('t_number')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('transaction_requested_at')->nullable();
            $table->dateTime('transaction_approved_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->useCurrent()->nullable();

            // Foreign key constraints
            $table->foreign('patient_user_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');

            $table->foreign('patient_subscription_id')
                  ->references('id')
                  ->on('patient_subscriptions')
                  ->onDelete('cascade')->name('fk_p_subs_trans_p_subscriptions');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('modified_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_subscription_transactions');
    }
}
