<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRelationshipMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relationship_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('relationship_user_id')->nullable();
            $table->unsignedBigInteger('x_relationship_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            // Foreign key constraints if needed
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('relationship_user_id')->references('id')->on('users');
            $table->foreign('x_relationship_id')->references('id')->on('x_relationship');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');

            // Indexes if needed
            // $table->index('user_id');
            // $table->index('relationship_user_id');
            // $table->index('relationship_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relationship_mapping');
    }
}
