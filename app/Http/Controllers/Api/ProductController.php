<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordClickRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get products with filters and search.
     */
    public function index(Request $request)
    {
        $products = $this->productService->getFilteredProductsForApi($request->all());
        return response()->json($products);
    }

    /**
     * Get single product detail.
     */
    public function show($idOrSlug)
    {
        $product = $this->productService->getProductByIdOrSlug($idOrSlug);
        return response()->json($product);
    }

    /**
     * Record a contact consultation click.
     */
    public function recordClick(RecordClickRequest $request)
    {
        $this->productService->recordClick(
            (int)$request->product_id,
            $request->ip()
        );

        return response()->json(['success' => true]);
    }
}

