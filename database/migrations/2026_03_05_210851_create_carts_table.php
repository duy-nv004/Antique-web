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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // user_id để null nếu bạn cho phép khách vãng lai (chưa đăng nhập) bỏ đồ vào giỏ
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // session_id dùng để nhận diện giỏ hàng của khách chưa đăng nhập dựa trên trình duyệt
            $table->string('session_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
