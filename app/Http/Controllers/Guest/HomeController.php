<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active categories
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get featured products (new arrivals)
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        return view('guest.home', compact('categories', 'featuredProducts'));
    }
}