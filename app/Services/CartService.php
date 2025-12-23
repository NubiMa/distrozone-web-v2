<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Exception;

class CartService
{
    /**
     * Get or create cart for user
     */
    public function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $userId],
            ['user_id' => $userId]
        );
    }

    /**
     * Add item to cart
     */
    public function addItem(int $userId, int $variantId, int $quantity = 1): CartItem
    {
        $cart = $this->getOrCreateCart($userId);
        
        // Validate variant and stock
        $variant = ProductVariant::with('product')
            ->where('id', $variantId)
            ->where('is_available', true)
            ->firstOrFail();

        if (!$variant->product->is_active) {
            throw new Exception('Product is not available');
        }

        // Check existing cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            if ($newQuantity > $variant->stock) {
                throw new Exception("Only {$variant->stock} items available in stock");
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $variant->price, // Update price in case it changed
            ]);
        } else {
            // Create new cart item
            if ($quantity > $variant->stock) {
                throw new Exception("Only {$variant->stock} items available in stock");
            }

            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $variant->price,
            ]);
        }

        return $cartItem->load('productVariant.product');
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $userId, int $cartItemId, int $quantity): CartItem
    {
        $cart = $this->getOrCreateCart($userId);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->with('productVariant')
            ->firstOrFail();

        if ($quantity <= 0) {
            $cartItem->delete();
            throw new Exception('Item removed from cart');
        }

        $variant = $cartItem->productVariant;

        if ($quantity > $variant->stock) {
            throw new Exception("Only {$variant->stock} items available in stock");
        }

        $cartItem->update([
            'quantity' => $quantity,
            'price' => $variant->price, // Update price in case it changed
        ]);

        return $cartItem->load('productVariant.product');
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $userId, int $cartItemId): void
    {
        $cart = $this->getOrCreateCart($userId);

        CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->delete();
    }

    /**
     * Clear entire cart
     */
    public function clearCart(int $userId): void
    {
        $cart = $this->getOrCreateCart($userId);
        $cart->items()->delete();
    }

    /**
     * Get cart summary
     */
    public function getCartSummary(int $userId): array
    {
        $cart = Cart::with(['items.productVariant.product.images'])
            ->where('user_id', $userId)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return [
                'items' => [],
                'subtotal' => 0,
                'total_items' => 0,
                'total_quantity' => 0,
            ];
        }

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->productVariant->product_id,
                'product_name' => $item->productVariant->product->name,
                'variant_id' => $item->product_variant_id,
                'color' => $item->productVariant->color,
                'size' => $item->productVariant->size,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->price * $item->quantity,
                'stock' => $item->productVariant->stock,
                'image' => $item->productVariant->product->primaryImage?->image_path,
            ];
        });

        return [
            'items' => $items,
            'subtotal' => $items->sum('subtotal'),
            'total_items' => $items->count(),
            'total_quantity' => $items->sum('quantity'),
        ];
    }
}