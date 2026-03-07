<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckTimeAccess;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->paginate(10);
        return view('admin.product.index', compact('products'));
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
        // dd($request->file('images'));
        DB::beginTransaction();
        try {
            // Tạo sản phẩm
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name) . '-' . time();
            $product->sku = $request->sku ?? 'DC-' . strtoupper(Str::random(6));
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->period = $request->period; // Niên đại
            $product->material = $request->material; // Chất liệu
            $product->condition = $request->condition;
            $product->origin = $request->origin;
            $product->content = $request->input('content');
            $product->is_active = $request->is_active;
            $product->save();

            // Xử lý upload nhiều ảnh
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main' => ($index == 0) ? 1 : 0, // Ảnh đầu tiên làm ảnh đại diện
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Thêm đồ cổ thành công!');
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
        $products = Product::find($id);
        $categories = Category::all();
        return view('admin.product.detail', compact('products', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->sale_price = $request->input('sale_price');
        $product->stock = $request->input('stock');
        $product->description = $request->input('description');
        $product->is_active = $request->input('is_active');
        $product->save();
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->is_deleted == true) {
            $product->is_deleted = false;
        } else {
            $product->is_deleted = true;
        }
        $product->save();
        return redirect('/products');
    }
}