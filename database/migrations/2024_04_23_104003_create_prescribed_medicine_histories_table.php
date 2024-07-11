<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribedMedicineHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribed_medicine_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->json('medicines')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->default(now()); // Use `dateTime` for non-timestamp columns
            $table->dateTime('updated_at')->nullable(); // Use `nullable` for `modified`

            // Define foreign key constraints
            // Uncomment and adjust the foreign key constraints if needed
             $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
             $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // Add other foreign key constraints as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescribed_medicine_histories');
    }
}
