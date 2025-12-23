<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with([
            'category',
            'images' => fn($q) => $q->orderBy('sort_order'),
            'variants' => fn($q) => $q->where('is_available', true)
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('guest.product-detail', compact('product'));
    }
}