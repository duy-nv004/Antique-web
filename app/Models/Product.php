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
        'discount_price',
        'stock',
        'period',               // Niên đại
        'material',             // Chất liệu
        'condition',            // Tình trạng
        'origin',               // Xuất xứ
        'content',              // Mô tả chi tiết
        'is_active',
        'availability_status',  // in_stock | sold | display
        'is_featured',
    ];

    /**
     * Tự động tạo slug khi lưu sản phẩm
     */
    protected static function booted()
    {
        static::saving(function ($product) {
            // Tự động tạo SKU nếu trống
            if (empty($product->sku)) {
                $product->sku = 'DC-' . strtoupper(\Illuminate\Support\Str::random(6));
            }

            if (empty($product->slug) || $product->isDirty('name')) {
                $product->slug = \Illuminate\Support\Str::slug($product->name) . '-' . time();
            }
        });
    }

    /**
     * Nhãn hiển thị cho availability_status
     */
    public function getAvailabilityLabelAttribute(): string
    {
        return match($this->availability_status) {
            'sold'    => 'Đã bán',
            default   => 'Còn hàng',
        };
    }

    /**
     * Scope: chỉ lấy sản phẩm đang hiển thị công khai
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', 1);
    }
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
