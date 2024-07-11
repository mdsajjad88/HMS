<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_menu_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name', 191);
            $table->timestamps(); // This will create `created_at` and `updated_at` columns
            $table->foreign('clinic_menu_id')->references('id')->on('clinic_menus')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
