<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $images = ['products/vase.png', 'products/clock.png', 'products/statue.png', 'products/box.png'];

        foreach ($products as $product) {
            // Kiểm tra xem sản phẩm đã có ảnh chưa để tránh lặp lại nếu chạy nhiều lần
            if ($product->images()->count() === 0) {
                // Tạo 1 ảnh chính
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => fake()->randomElement($images),
                    'is_main' => true,
                    'is_active' => true,
                ]);

                // Tạo thêm 1-3 ảnh phụ
                ProductImage::factory(rand(1, 3))->create([
                    'product_id' => $product->id,
                    'is_main' => false,
                ]);
            }
        }
    }
}
