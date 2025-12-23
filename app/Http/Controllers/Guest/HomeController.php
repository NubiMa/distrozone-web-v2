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
        // Get new products (last 8)
        $newProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('guest.home', compact('newProducts'));
    }
}