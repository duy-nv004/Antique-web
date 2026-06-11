<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'sku' => strtoupper(fake()->unique()->bothify('ANT-####-??')),
            'price' => fake()->randomFloat(2, 500, 50000),
            'stock' => fake()->numberBetween(0, 10),
            'is_active' => true,
            'availability_status' => fake()->randomElement(['in_stock', 'sold']),
            'period' => fake()->randomElement(['Thế kỷ 18', 'Triều Nguyễn', 'Nhà Minh', 'Pháp thuộc', 'Thế kỷ 19']),
            'material' => fake()->randomElement(['Gỗ trắc', 'Sứ xanh trắng', 'Đồng thau', 'Ngọc bích', 'Gỗ sưa']),
            'condition' => fake()->randomElement(['Nguyên bản', 'Phục chế nhẹ', 'Hơi trầy xước', 'Hoàn hảo']),
            'origin' => fake()->randomElement(['Việt Nam', 'Trung Hoa', 'Pháp', 'Nhật Bản']),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
