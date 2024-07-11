<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTargetSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_target_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->double('target_amount', 8, 2)->default(0.00);
            $table->integer('commission_percentage')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints if necessary
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_target_sales');
    }
}
