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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id')->unique()->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->uuid('order_id');
            $table->string('transaction_reference')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method');
            $table->string('link');
            $table->string('completed_at')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
