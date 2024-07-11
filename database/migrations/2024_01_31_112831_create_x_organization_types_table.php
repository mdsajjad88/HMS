<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOrganizationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_organization_types', function (Blueprint $table) {
            $table->id();
            $table->integer('type_code')->nullable(false);
            $table->string('type_name', 255)->nullable(false);
            $table->integer('x_organization_type_group_id')->nullable(false)->default(0);
            $table->string('icon', 100)->nullable();
            $table->integer('show_status')->nullable(false)->default(0);
            $table->dateTime('created')->nullable(false);
            $table->dateTime('modified')->nullable(false);
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
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
        Schema::dropIfExists('x_organization_types');
    }
}
