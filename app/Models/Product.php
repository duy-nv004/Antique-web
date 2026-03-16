<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'stock',
        'period',    // Niên đại
        'material',  // Chất liệu
        'condition', // Tình trạng
        'origin',    // Xuất xứ
        'content',   // Mô tả chi tiết
        'is_active',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với bảng Ảnh (1 sản phẩm có nhiều ảnh)
    // Trong file Product.php
public function images()
{
    // Giả sử khóa ngoại ở bảng product_images là product_id
    return $this->hasMany(ProductImage::class, 'product_id');
}

// Thêm một hàm helper để lấy nhanh ảnh chính (is_main = 1)
public function mainImage()
{
    return $this->hasOne(ProductImage::class, 'product_id')->where('is_main', 1);
}
}
