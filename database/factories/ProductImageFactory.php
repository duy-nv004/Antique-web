<?php

namespace Database\Factories;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $images = ['products/vase.png', 'products/clock.png', 'products/statue.png', 'products/box.png'];
        return [
            'product_id' => \App\Models\Product::factory(),
            'image_path' => fake()->randomElement($images),
            'is_main' => false,
            'is_active' => true,
        ];
    }
}
