<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name', 200);
            $table->string('medicine_code', 80)->nullable();
            $table->date('medicine_mfg_date');
            $table->date('medicine_exp_date')->nullable();
            $table->tinyInteger('medicine_type');
            $table->string('medicine_unit', 50)->nullable();
            $table->string('pharmacy_name', 200)->nullable();
            $table->text('pharmacy_details')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->datetime('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_medicines');
    }
}
