<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStatsController extends Controller
{
    /**
     * Get dashboard statistics.
     */
    public function index()
    {
        // 1. Product count by category
        $categoryStats = Category::withCount('products')
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'count' => $cat->products_count
                ];
            });

        // 2. Contact clicks over time (last 30 days)
        $clickStats = ContactClick::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(30)
            ->get();

        // 3. Total stats
        $totalProducts = Product::count();
        $totalClicks = ContactClick::count();

        return response()->json([
            'category_stats' => $categoryStats,
            'click_stats' => $clickStats,
            'totals' => [
                'products' => $totalProducts,
                'clicks' => $totalClicks
            ]
        ]);
    }
}
