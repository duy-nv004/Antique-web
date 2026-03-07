<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('order_code')->unique();
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending'); // pending, shipping, completed, cancelled

            // Thông tin giao hàng tại thời điểm mua (Snapshot)
            $table->string('shipping_fullname');
            $table->string('shipping_phone');
            $table->text('shipping_address');

            $table->string('payment_method')->default('cod');
            $table->string('payment_status')->default('unpaid');
            $table->softDeletes();
            $table->timestamps();
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
