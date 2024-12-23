<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOwnershipAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_ownership_authorities', function (Blueprint $table) {
            $table->id();
            $table->integer('ownership_code')->nullable(false);
            $table->string('ownership_name', 255)->nullable(false);
            $table->dateTime('created')->nullable(false);
            $table->dateTime('modified')->nullable(false);
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
        Schema::dropIfExists('x_ownership_authorities');
    }
}
