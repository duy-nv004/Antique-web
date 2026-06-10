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
            ['name' => 'Đồ Ngọc & Đá Quý', 'description' => 'Hiện vật chế tác từ ngọc và đá phong thủy xưa'],
            ['name' => 'Đồ Thủy Tinh & Pha Lê', 'description' => 'Bình hoa, ly tách thủy tinh, pha lê cổ Âu Châu'],
            ['name' => 'Đồng Hồ Cổ', 'description' => 'Đồng hô để bàn, đồng hồ quả lắc xưa'],
            ['name' => 'Đèn Cổ', 'description' => 'Đèn dầu bão, đèn chùm cổ điển'],
            ['name' => 'Nhạc Cụ Cổ', 'description' => 'Nhạc cụ phát nhạc cơ học xưa'],
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
