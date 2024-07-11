<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_agencies', function (Blueprint $table) {
            $table->id();
            $table->integer('agency_code')->unique();
            $table->string('agency_name', 255);
            $table->datetime('created')->nullable(false); // Set as not nullable
            $table->datetime('modified')->nullable(false); // Set as not nullable
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
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
        Schema::dropIfExists('x_agencies');
    }
}
