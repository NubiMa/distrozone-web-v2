<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Get cart items
     */
    public function index(Request $request)
    {
        $cart = $this->cartService->getCartSummary($request->user()->id);

        return view('customer.cart', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cartItem = $this->cartService->addItem(
                $request->user()->id,
                $validated['product_variant_id'],
                $validated['quantity']
            );

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'data' => $cartItem,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $cartItem = $this->cartService->updateQuantity(
                $request->user()->id,
                $id,
                $validated['quantity']
            );

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'data' => $cartItem,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request, int $id)
    {
        try {
            $this->cartService->removeItem($request->user()->id, $id);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        $this->cartService->clearCart($request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }

    /**
     * Get cart summary
     */
    public function summary(Request $request)
    {
        $summary = $this->cartService->getCartSummary($request->user()->id);

        return response()->json([
            'success' => true,
            'data' => $summary,
        ]);
    }
}
