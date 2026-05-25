<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['keyword', 'category_id', 'is_active', 'status']);
        $products = $this->productService->getFilteredProductsForAdmin($filters, 10);
        $categories = $this->categoryService->getAllCategories();

        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getActiveCategories();
        return view('admin.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->safe()->except(['images']);
            $images = $request->file('images');

            $this->productService->createProduct($data, $images);

            return redirect()->route('admin.products.index')->with('success', 'Thêm đồ cổ thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $products = $this->productService->getProductByIdOrSlug((string)$id);
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.detail', compact('products', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->getProductByIdOrSlug($id);
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = $this->productService->getProductByIdOrSlug($id);
            $data = $request->safe()->except(['images', 'delete_images', 'main_image_id']);
            $images = $request->file('images');
            $deleteImageIds = $request->input('delete_images');
            $mainImageId = $request->input('main_image_id') ? (int)$request->input('main_image_id') : null;

            $this->productService->updateProduct($product, $data, $images, $deleteImageIds, $mainImageId);

            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id)
    {
        try {
            $product = $this->productService->getProductByIdOrSlug($id);
            $this->productService->deleteProduct($product);
            return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}