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
        Schema::table('products', function (Blueprint $table) {
            // Trạng thái hàng hóa theo mô hình Catalog & Connect
            $table->enum('availability_status', ['in_stock', 'sold', 'display'])
                  ->default('in_stock')
                  ->after('is_active')
                  ->comment('in_stock: Còn hàng, sold: Đã bán, display: Trưng bày');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('availability_status');
        });
    }
};
