<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->useCurrent();

            // Optionally, you can use the following lines to add 'created_at' and 'updated_at' fields
             $table->timestamps();

            // If you want to disable Laravel's default timestamp columns 'created_at' and 'updated_at', comment out the line above and uncomment the lines below
            //  $table->timestamp('created_at')->useCurrent();
            //  $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_categories');
    }
}
