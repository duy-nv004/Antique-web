<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ContactClick;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Query products for admin with filters.
     */
    public function getFilteredProductsForAdmin(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with('category', 'images')->latest();

        // Lọc theo từ khóa (tên hoặc SKU)
        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['keyword'] . '%')
                  ->orWhere('sku', 'like', '%' . $filters['keyword'] . '%');
            });
        }

        // Lọc theo danh mục
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Lọc theo trạng thái hiển thị
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        // Lọc theo trạng thái hàng hóa
        if (!empty($filters['status'])) {
            $query->where('availability_status', $filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Query products for public API with search, category filter, limit, and pagination.
     */
    public function getFilteredProductsForApi(array $params)
    {
        $query = Product::select([
            'id',
            'category_id',
            'name',
            'slug',
            'price',
            'discount_price',
            'period',
            'origin',
            'availability_status',
            'is_active'
        ])
        ->with([
            'category:id,name',
            'images:id,product_id,image_path,is_main'
        ])
        ->where('is_active', true);

        // Lọc theo danh mục
        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        // Tìm kiếm theo tên
        if (!empty($params['search'])) {
            $query->where('name', 'like', '%' . $params['search'] . '%');
        }

        // Lọc theo khoảng giá
        if (isset($params['min_price']) && $params['min_price'] !== '') {
            $query->where('price', '>=', (float)$params['min_price']);
        }
        if (isset($params['max_price']) && $params['max_price'] !== '') {
            $query->where('price', '<=', (float)$params['max_price']);
        }

        // Lọc theo trạng thái đã bán / chưa bán (còn hàng hoặc đã bán)
        if (!empty($params['status'])) {
            if ($params['status'] === 'sold') {
                $query->where('availability_status', 'sold');
            } elseif ($params['status'] === 'in_stock') {
                $query->where('availability_status', 'in_stock');
            }
        }

        // Lọc sản phẩm mới (ví dụ: tạo trong vòng 30 ngày gần đây)
        if (isset($params['is_new']) && $params['is_new'] === 'true') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        // Sắp xếp
        if (!empty($params['sort_by'])) {
            if ($params['sort_by'] === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($params['sort_by'] === 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        // Phân trang hoặc giới hạn số lượng trả về
        if (!empty($params['limit'])) {
            return $query->limit((int)$params['limit'])->get();
        }

        $perPage = (int)($params['per_page'] ?? 12);
        return $query->paginate($perPage);
    }

    /**
     * Find single product by ID or Slug.
     */
    public function getProductByIdOrSlug(string $idOrSlug): Product
    {
        $query = Product::with(['category', 'images']);

        if (is_numeric($idOrSlug)) {
            $query->where(function ($q) use ($idOrSlug) {
                $q->where('id', $idOrSlug)
                  ->orWhere('slug', $idOrSlug);
            });
        } else {
            $query->where('slug', $idOrSlug);
        }

        return $query->firstOrFail();
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data, ?array $imageFiles): Product
    {
        return DB::transaction(function () use ($data, $imageFiles) {
            $product = Product::create($data);

            if (!empty($imageFiles)) {
                foreach ($imageFiles as $index => $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('products', $fileName, 'public');
                    $path = 'products/' . $fileName;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main'    => ($index === 0) ? 1 : 0,
                    ]);
                }
            }

            return $product;
        });
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(Product $product, array $data, ?array $imageFiles, ?array $deleteImageIds, ?int $mainImageId): Product
    {
        return DB::transaction(function () use ($product, $data, $imageFiles, $deleteImageIds, $mainImageId) {
            $product->update($data);

            // 1. Xử lý xóa ảnh cũ
            if (!empty($deleteImageIds)) {
                foreach ($deleteImageIds as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // 2. Xử lý đặt ảnh chính
            if (!empty($mainImageId)) {
                ProductImage::where('product_id', $product->id)->update(['is_main' => 0]);
                ProductImage::where('id', $mainImageId)->update(['is_main' => 1]);
            }

            // 3. Xử lý upload ảnh mới nếu có
            if (!empty($imageFiles)) {
                foreach ($imageFiles as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('products', $fileName, 'public');
                    $path = 'products/' . $fileName;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main'    => 0,
                    ]);
                }
            }

            return $product->load('images');
        });
    }

    /**
     * Delete a product (Soft delete).
     */
    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }

    /**
     * Record a contact consultation click.
     */
    public function recordClick(int $productId, ?string $ipAddress): ContactClick
    {
        return ContactClick::create([
            'product_id' => $productId,
            'ip_address' => $ipAddress
        ]);
    }
}
