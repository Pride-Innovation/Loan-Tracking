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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number', 50)->unique();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('relationship_officer_id');
            $table->unsignedBigInteger('loan_product_id');
            $table->string('client_name', 255);
            $table->string('client_phone', 20);
            $table->string('client_email', 255)->nullable();
            $table->string('customer_reference_number', 100);
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('net_amount', 15, 2)->nullable();
            $table->decimal('interest_rate', 5, 2);
            $table->enum('loan_type', ['New', 'Top up']);
            $table->date('application_date');
            $table->unsignedBigInteger('current_stage_id')->nullable();
            $table->timestamp('current_stage_entered_at')->nullable();
            $table->integer('total_tat_hours')->default(0);
            $table->boolean('is_overdue')->default(false);
            $table->enum('final_status', ['Approved', 'Rejected', 'Deferred', 'Disbursed'])->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('relationship_officer_id')->references('id')->on('users');
            $table->foreign('loan_product_id')->references('id')->on('loan_products');
            $table->foreign('current_stage_id')->references('id')->on('loan_stages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
