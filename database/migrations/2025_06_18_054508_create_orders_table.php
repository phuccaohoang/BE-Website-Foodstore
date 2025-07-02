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
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('phone', 10);
            $table->string('address', 300);
            $table->decimal('total_amount', 10, 2)->unsigned();
            $table->unsignedTinyInteger('quantity');
            $table->decimal('delivery_cost', 10, 2)->unsigned();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->string('note', 300)->nullable();
            $table->boolean('is_payment')->default(0);
            $table->foreignId('order_status_id')->constrained('order_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
