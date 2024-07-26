<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXWhoIscoOccupationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_who_isco_occupations', function (Blueprint $table) {
            $table->id();
            $table->integer('x_who_major_group_id')->nullable(false);
            $table->string('who_specific_group_code', 10)->nullable(false);
            $table->string('who_specific_group_name', 255)->nullable(false);
            $table->string('isco_code', 10)->nullable(false);
            $table->string('isco_occupion_name', 255)->nullable(false);
            $table->text('definition')->nullable();
            $table->text('example')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('modified')->nullable();
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
        Schema::dropIfExists('x_who_isco_occupations');
    }
}
