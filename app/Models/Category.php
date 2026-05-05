<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];

    /**
     * Tự động tạo slug khi lưu danh mục
     */
    protected static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug) || $category->isDirty('name')) {
                $category->slug = \Illuminate\Support\Str::slug($category->name) . '-' . time();
            }
        });
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Lấy danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Lấy các danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
