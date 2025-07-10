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
        Schema::create('approval_work_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_product_id');
            $table->decimal('amount_min', 15, 2);
            $table->decimal('amount_max', 15, 2);
            $table->unsignedBigInteger('required_stage_id');
            $table->integer('order_sequence');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_work_flows');
    }
};
