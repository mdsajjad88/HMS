<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXSecondDivisionCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_second_division_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('second_level_code')->nullable(false);
            $table->string('second_level_name', 255)->nullable(false);
            $table->integer('created_by')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('modified_by')->nullable();
            $table->dateTime('modified')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_second_division_codes');
    }
}
