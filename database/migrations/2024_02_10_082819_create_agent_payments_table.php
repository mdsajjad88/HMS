<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agent_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id');
            $table->unsignedBigInteger('agent_profile_id');
            $table->string('month_name');
            $table->decimal('price_total', 10, 2);
            $table->decimal('organization_discount', 10, 2);
            $table->decimal('payable_amount', 10, 2);
            $table->decimal('agent_discount', 10, 2);
            $table->decimal('agent_commission', 10, 2);
            $table->decimal('arget_sale_commission_percentage', 5, 2);
            $table->decimal('arget_sale_commission_amount', 10, 2);
            $table->decimal('agent_payable_amount', 10, 2);
            $table->decimal('agent_paid_amount', 10, 2);
            $table->string('payment_status');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
             $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
             $table->foreign('agent_profile_id')->references('id')->on('agent_profiles')->onDelete('cascade');
             $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
             $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_payments');
    }
};
