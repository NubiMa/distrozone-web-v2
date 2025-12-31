<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = Wishlist::with('product.primaryImage')
            ->where('user_id', $user->id)
            ->get();

        return view('customer.wishlist', compact('wishlistItems'));
    }

    public function toggle($productId)
    {
        $user = Auth::user();
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // If item exists in wishlist, remove it
            $wishlistItem->delete();
            return response()->json(['message' => 'Product removed from wishlist.']);
        } else {
            // If item does not exist, add it to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return response()->json(['message' => 'Product added to wishlist.']);
        }
    }
}
