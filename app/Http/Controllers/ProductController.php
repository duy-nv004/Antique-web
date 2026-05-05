<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')->latest();

        // Lọc theo từ khóa (tên hoặc SKU)
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('sku', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo trạng thái hiển thị
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Lọc theo trạng thái hàng hóa
        if ($request->filled('status')) {
            $query->where('availability_status', $request->status);
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('admin.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            // Loại bỏ images khỏi dữ liệu khi tạo Product
            $product = Product::create($request->safe()->except(['images']));

            // Xử lý upload nhiều ảnh
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/products'), $fileName);
                    $path = 'products/' . $fileName;

                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main'    => ($index == 0) ? 1 : 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Thêm đồ cổ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $products   = Product::with('images', 'category')->findOrFail($id);
        $categories = Category::all();
        return view('admin.product.detail', compact('products', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product    = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Cập nhật thông tin cơ bản, loại bỏ các trường không thuộc bảng products
            $product->update($request->safe()->except(['images', 'delete_images', 'main_image_id']));

            // 1. Xử lý xóa ảnh cũ
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = \App\Models\ProductImage::find($imageId);
                    if ($image) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // 2. Xử lý đặt ảnh chính
            if ($request->filled('main_image_id')) {
                \App\Models\ProductImage::where('product_id', $product->id)->update(['is_main' => 0]);
                \App\Models\ProductImage::where('id', $request->main_image_id)->update(['is_main' => 1]);
            }

            // 3. Xử lý upload ảnh mới nếu có
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/products'), $fileName);
                    $path = 'products/' . $fileName;

                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main'    => 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // SoftDelete
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}