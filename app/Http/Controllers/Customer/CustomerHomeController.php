<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerHomeController extends Controller
{
    public function index()
    {
        // Get active categories
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // Get featured products (last 8)
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('customer.home', compact('categories', 'featuredProducts'));
    }
}
