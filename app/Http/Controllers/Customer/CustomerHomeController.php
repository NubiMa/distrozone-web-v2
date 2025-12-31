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
        // Get new products (last 8)
        $newProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('customer.home', compact('newProducts'));
    }
}
