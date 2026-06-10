<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('No categories found, seeding categories first...');
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        foreach ($categories as $category) {
            // Tạo 25 sản phẩm cho mỗi danh mục
            Product::factory(25)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
