<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Get all products (admin view)
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage', 'variants']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get single product
     */
    public function show(int $id)
    {
        $product = Product::with(['category', 'images', 'variants'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Create new product
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'base_price' => $validated['base_price'],
            'cost_price' => $validated['cost_price'],
            'weight' => $validated['weight'],
            'is_active' => $validated['is_active'] ?? true,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }

    /**
     * Update product
     */
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|unique:products,sku,' . $id,
            'description' => 'nullable|string',
            'base_price' => 'sometimes|numeric|min:0',
            'cost_price' => 'sometimes|numeric|min:0',
            'weight' => 'sometimes|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ]);
    }

    /**
     * Delete product
     */
    public function delete(int $id)
    {
        $product = Product::findOrFail($id);

        // Check if product has orders
        if ($product->orderItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product with existing orders',
            ], 400);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Toggle product active status
     */
    public function toggleActive(int $id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated',
            'data' => [
                'is_active' => $product->is_active,
            ],
        ]);
    }

    /**
     * Add product variant
     */
    public function addVariant(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'color' => 'required|string|max:255',
            'size' => 'required|in:XS,S,M,L,XL,XXL,XXXL',
            'sku' => 'required|string|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'color' => $validated['color'],
            'size' => $validated['size'],
            'sku' => $validated['sku'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'min_stock' => $validated['min_stock'],
            'is_available' => $validated['is_available'] ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Variant added successfully',
            'data' => $variant,
        ], 201);
    }

    /**
     * Update product variant
     */
    public function updateVariant(Request $request, int $id, int $variantId)
    {
        $product = Product::findOrFail($id);
        $variant = ProductVariant::where('product_id', $product->id)
            ->where('id', $variantId)
            ->firstOrFail();

        $validated = $request->validate([
            'color' => 'sometimes|string|max:255',
            'size' => 'sometimes|in:XS,S,M,L,XL,XXL,XXXL',
            'sku' => 'sometimes|string|unique:product_variants,sku,' . $variantId,
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'min_stock' => 'sometimes|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $variant->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Variant updated successfully',
            'data' => $variant,
        ]);
    }

    /**
     * Delete product variant
     */
    public function deleteVariant(int $id, int $variantId)
    {
        $product = Product::findOrFail($id);
        $variant = ProductVariant::where('product_id', $product->id)
            ->where('id', $variantId)
            ->firstOrFail();

        // Check if variant has orders
        if ($variant->orderItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete variant with existing orders',
            ], 400);
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variant deleted successfully',
        ]);
    }

    /**
     * Upload product image
     */
    public function uploadImage(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
        ]);

        // Store image
        $imagePath = $request->file('image')->store('products', 'public');

        // If this is primary, unset other primary images
        if ($validated['is_primary'] ?? false) {
            ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => false]);
        }

        // Get next sort order
        $sortOrder = ProductImage::where('product_id', $product->id)->max('sort_order') + 1;

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $sortOrder,
            'is_primary' => $validated['is_primary'] ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'data' => $image,
        ], 201);
    }

    /**
     * Delete product image
     */
    public function deleteImage(int $id, int $imageId)
    {
        $product = Product::findOrFail($id);
        $image = ProductImage::where('product_id', $product->id)
            ->where('id', $imageId)
            ->firstOrFail();

        // Delete file from storage
        if ($image->image_path) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully',
        ]);
    }

    /**
     * Set primary image
     */
    public function setPrimaryImage(int $id, int $imageId)
    {
        $product = Product::findOrFail($id);
        $image = ProductImage::where('product_id', $product->id)
            ->where('id', $imageId)
            ->firstOrFail();

        // Unset all primary images
        ProductImage::where('product_id', $product->id)
            ->update(['is_primary' => false]);

        // Set this as primary
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Primary image updated',
            'data' => $image,
        ]);
    }
}