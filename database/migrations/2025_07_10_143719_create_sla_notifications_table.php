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
        Schema::create('sla_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id');
            $table->unsignedBigInteger('current_stage_id');
            $table->unsignedBigInteger('escalated_to_stage_id')->nullable();
            $table->string('escalation_reason', 255);
            $table->timestamp('escalated_at')->useCurrent();
            $table->enum('escalated_by', ['system', 'manual'])->default('system');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('loan_application_id')
                ->references('id')->on('loan_applications')
                ->onDelete('cascade');
            $table->foreign('current_stage_id')
                ->references('id')->on('loan_stages');
            $table->foreign('escalated_to_stage_id')
                ->references('id')->on('loan_stages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sla_notifications');
    }
};
