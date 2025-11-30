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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->enum('order_type', ['pickup', 'delivery'])->default('delivery');
            $table->uuid('shipping_address_id')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('delivered_at')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
