<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products (with filters and pagination)
     */
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
        if ($request->has('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Filter featured
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['name', 'base_price', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        // Transform response
        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->base_price,
                'price_range' => [
                    'min' => $product->getLowestPrice(),
                    'max' => $product->getHighestPrice(),
                ],
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug,
                ],
                'image' => $product->primaryImage?->image_path,
                'is_featured' => $product->is_featured,
                'in_stock' => $product->isInStock(),
                'total_stock' => $product->getTotalStock(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Get single product by slug
     */
    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'images' => fn($q) => $q->orderBy('sort_order'),
            'variants' => fn($q) => $q->where('is_available', true)
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'description' => $product->description,
                'base_price' => $product->base_price,
                'weight' => $product->weight,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug,
                ],
                'images' => $product->images->map(fn($img) => [
                    'id' => $img->id,
                    'path' => $img->image_path,
                    'alt' => $img->alt_text,
                    'is_primary' => $img->is_primary,
                ]),
                'variants' => $product->variants->map(fn($v) => [
                    'id' => $v->id,
                    'sku' => $v->sku,
                    'color' => $v->color,
                    'size' => $v->size,
                    'price' => $v->price,
                    'stock' => $v->stock,
                    'is_available' => $v->is_available && $v->stock > 0,
                ]),
                'is_featured' => $product->is_featured,
                'total_stock' => $product->getTotalStock(),
            ],
        ]);
    }

    /**
     * Get product variants
     */
    public function variants(int $id)
    {
        $product = Product::findOrFail($id);
        
        $variants = $product->variants()
            ->where('is_available', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $variants->map(fn($v) => [
                'id' => $v->id,
                'sku' => $v->sku,
                'color' => $v->color,
                'size' => $v->size,
                'price' => $v->price,
                'stock' => $v->stock,
                'is_available' => $v->stock > 0,
            ]),
        ]);
    }
}