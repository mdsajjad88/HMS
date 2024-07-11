<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOrganizationTypeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_organization_type_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name', 255)->nullable(false);
            $table->string('icon', 100)->nullable();
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
        Schema::dropIfExists('x_organization_type_groups');
    }
}
