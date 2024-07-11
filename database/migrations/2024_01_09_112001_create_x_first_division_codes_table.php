<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXFirstDivisionCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_first_division_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('first_level_code')->unique();
            $table->string('first_level_name', 255);
            $table->integer('created_by')->nullable();
            $table->datetime('created')->nullable();
            $table->integer('modified_by')->nullable();
            $table->datetime('modified')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_first_division_codes');
    }
}
