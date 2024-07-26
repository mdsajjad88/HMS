<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateDiseaseDetailsFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_details_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label_name', 191)->nullable();
            $table->string('name', 191);
            $table->string('type', 50);
            $table->integer('value')->nullable();
            $table->string('placeholder', 191)->nullable();
            $table->string('class', 191)->nullable();
            $table->tinyInteger('is_multiple')->default(0);
            $table->tinyInteger('is_required')->default(0);
            $table->integer('position')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints if necessary
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
        Schema::dropIfExists('disease_details_fields');
    }
}
