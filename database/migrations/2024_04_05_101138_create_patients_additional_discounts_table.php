<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsAdditionalDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_additional_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->enum('discount_type', ['Percentage', 'Fixed']);
            $table->integer('discount');
            $table->text('remarks')->nullable();
            $table->string('helped_by', 191)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_application')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
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
        Schema::dropIfExists('patients_additional_discounts');
    }
}
