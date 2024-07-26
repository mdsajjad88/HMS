<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXWhoMajorGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_who_major_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('occupation_code')->nullable(false);
            $table->string('occupation_group_name', 255)->nullable(false);
            $table->integer('created_by')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('modified_by')->nullable();
            $table->dateTime('modified')->nullable();
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
        Schema::dropIfExists('x_who_major_groups');
    }
}
