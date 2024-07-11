<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_id');
            $table->unsignedBigInteger('patient_user_id');
            $table->unsignedBigInteger('added_by');
            $table->timestamps(); // This will create `created_at` and `updated_at` columns

            // Define foreign key constraints
            // Uncomment and adjust the foreign key constraints if needed
            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memo_references');
    }
}
