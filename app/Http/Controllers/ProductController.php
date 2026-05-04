<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = new Product;
            $product->category_id        = $request->category_id;
            $product->name               = $request->name;
            $product->slug               = Str::slug($request->name) . '-' . time();
            $product->sku                = $request->sku ?? 'DC-' . strtoupper(Str::random(6));
            $product->price              = $request->price;
            $product->stock              = $request->stock ?? 1;
            $product->period             = $request->period;
            $product->material           = $request->material;
            $product->condition          = $request->condition;
            $product->origin             = $request->origin;
            $product->content            = $request->input('content');
            $product->is_active          = $request->is_active ?? 1;
            $product->availability_status = $request->availability_status ?? 'in_stock';
            $product->save();

            // Xử lý upload nhiều ảnh
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
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
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->category_id         = $request->input('category_id');
        $product->name                = $request->input('name');
        $product->slug                = Str::slug($request->input('name')) . '-' . $product->id;
        $product->price               = $request->input('price');
        $product->stock               = $request->input('stock', 1);
        $product->period              = $request->input('period');
        $product->material            = $request->input('material');
        $product->condition           = $request->input('condition');
        $product->origin              = $request->input('origin');
        $product->content             = $request->input('content');
        $product->is_active           = $request->input('is_active', 1);
        $product->availability_status = $request->input('availability_status', 'in_stock');
        $product->save();

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main'    => 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
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