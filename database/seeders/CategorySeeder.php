<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Đồ Gỗ Mỹ Nghệ', 'description' => 'Các sản phẩm từ gỗ quý hiếm'],
            ['name' => 'Gốm Sứ Cổ', 'description' => 'Gốm sứ từ các triều đại'],
            ['name' => 'Đồ Đồng Phục Cổ', 'description' => 'Các vật dụng bằng đồng xưa'],
            ['name' => 'Tranh & Thư Pháp', 'description' => 'Tranh cổ và chữ thư pháp'],
            ['name' => 'Trang Sức Cổ', 'description' => 'Vàng bạc đá quý xưa'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
