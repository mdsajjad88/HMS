<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientMedicalTestTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_test_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_user_id');
            $table->unsignedBigInteger('patient_medical_test_id');
            $table->tinyInteger('t_type')->comment('1:credit, 2:deduct');
            $table->double('t_amount', 8, 2)->default(0.00);
            $table->integer('agent_commission_percentage')->default(0);
            $table->integer('agent_commission_amount')->default(0);
            $table->integer('agent_discount_percentage')->default(0);
            $table->integer('agent_discount_amount')->default(0);
            $table->integer('organization_discount_amount')->default(0);
            $table->double('discount_amount', 8, 2)->default(0.00);
            $table->string('t_txid', 50);
            $table->text('t_log')->nullable();
            $table->tinyInteger('t_status')->default(0);
            $table->string('t_media', 100)->nullable()->comment('bkash,rocket etc');
            $table->text('t_number')->nullable();
            $table->text('remarks')->nullable();
            $table->datetime('transaction_requested_at')->nullable();
            $table->datetime('transaction_approved_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->string('helped_by', 191)->nullable()->default(null);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();

            $table->foreign('patient_medical_test_id')->references('id')->on('patient_medical_tests')->name('fk_p_medi_test_in_test_transaction');
            $table->foreign('patient_user_id')->references('id')->on('patient_users');
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
        Schema::dropIfExists('patient_medical_test_transactions');
    }
}
