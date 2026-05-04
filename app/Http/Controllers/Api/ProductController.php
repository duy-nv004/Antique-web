<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactClick;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get products with filters and search.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->where('is_active', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination or Limit
        if ($request->has('limit')) {
            $products = $query->latest()->limit($request->limit)->get();
        } else {
            $perPage = $request->get('per_page', 12);
            $products = $query->latest()->paginate($perPage);
        }

        return response()->json($products);
    }

    /**
     * Get single product detail.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Record a contact consultation click.
     */
    public function recordClick(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        ContactClick::create([
            'product_id' => $request->product_id,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['success' => true]);
    }
}
