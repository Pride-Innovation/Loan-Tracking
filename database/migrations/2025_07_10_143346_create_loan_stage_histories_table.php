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
        Schema::create('loan_stage_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id');
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('action', ['forwarded', 'approved', 'rejected', 'deferred', 'returned']);
            $table->text('comments');
            $table->integer('time_spent_hours')->default(0);
            $table->timestamp('entered_at');
            $table->timestamp('exited_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('loan_application_id')->references('id')->on('loan_applications')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('loan_stages');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_stage_histories');
    }
};
