<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage', 'variants'])
            ->where('is_active', true);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by search keyword
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by price range
        if ($request->has('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Filter by sizes (if selected)
        if ($request->has('sizes')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size', $request->sizes)
                  ->where('is_available', true)
                  ->where('stock', '>', 0);
            });
        }

        // Quick filters (new, sale, featured)
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'sale':
                    // Can add sale logic here if needed
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'popular':
                $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->latest();
        }

        // Paginate results
        $products = $query->paginate(12);

        // Get all categories for filter sidebar
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('guest.catalog', compact('products', 'categories'));
    }
}