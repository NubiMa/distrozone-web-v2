<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Create order from cart
     */
    public function createOrderFromCart(
        int $userId,
        int $addressId,
        ?string $customerNotes = null
    ): Order {
        return DB::transaction(function () use ($userId, $addressId, $customerNotes) {
            $cart = Cart::with(['items.productVariant.product'])
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw new Exception('Cart is empty');
            }

            // Get shipping address
            $address = \App\Models\CustomerAddress::where('user_id', $userId)
                ->where('id', $addressId)
                ->firstOrFail();

            // Validate stock availability
            $this->validateStock($cart);

            // Calculate totals
            $subtotal = $this->calculateSubtotal($cart);
            $totalWeight = $this->calculateTotalWeight($cart);

            // Calculate shipping
            $shipping = $this->shippingService->calculateShippingCost(
                $address->city,
                $address->province,
                $totalWeight
            );

            $total = $subtotal + $shipping['shipping_cost'];

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $userId,
                'status' => 'pending_payment',
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping['shipping_cost'],
                'total' => $total,
                'recipient_name' => $address->recipient_name,
                'recipient_phone' => $address->phone,
                'shipping_address' => $address->address,
                'city' => $address->city,
                'province' => $address->province,
                'postal_code' => $address->postal_code,
                'total_weight' => $totalWeight,
                'shipping_weight' => $shipping['shipping_weight_kg'],
                'customer_notes' => $customerNotes,
            ]);

            // Create order items (snapshot product data)
            foreach ($cart->items as $cartItem) {
                $variant = $cartItem->productVariant;
                $product = $variant->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $product->name,
                    'product_sku' => $variant->sku,
                    'variant_color' => $variant->color,
                    'variant_size' => $variant->size,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'cost_price' => $product->cost_price,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            return $order->load('items', 'payment');
        });
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Order $order, string $newStatus, ?int $userId = null): Order
    {
        $validTransitions = $this->getValidStatusTransitions();

        if (!isset($validTransitions[$order->status]) ||
            !in_array($newStatus, $validTransitions[$order->status])) {
            throw new Exception("Cannot change status from {$order->status} to {$newStatus}");
        }

        $order->status = $newStatus;

        // Track special status changes
        if ($newStatus === 'verified' && !$order->verified_at) {
            $order->verified_by = $userId;
            $order->verified_at = now();
        }

        if ($newStatus === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }

        if ($newStatus === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }

        $order->save();

        return $order;
    }

    /**
     * Verify payment and deduct stock
     */
    public function verifyPayment(Order $order, int $cashierId): Order
    {
        return DB::transaction(function () use ($order, $cashierId) {
            // Check if payment exists
            if (!$order->payment || $order->payment->status !== 'pending') {
                throw new Exception('Payment not found or already processed');
            }

            // Deduct stock
            $this->deductStock($order);

            // Update payment status
            $order->payment->update([
                'status' => 'verified',
                'verified_by' => $cashierId,
                'verified_at' => now(),
            ]);

            // Update order status
            $this->updateOrderStatus($order, 'verified', $cashierId);
            $this->updateOrderStatus($order, 'processing', $cashierId);

            return $order->fresh();
        });
    }

    /**
     * Deduct stock after payment verification
     */
    private function deductStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $variant = ProductVariant::lockForUpdate()
                ->findOrFail($item->product_variant_id);

            if ($variant->stock < $item->quantity) {
                throw new Exception(
                    "Insufficient stock for {$item->product_name} - {$item->variant_color} {$item->variant_size}"
                );
            }

            $variant->decrement('stock', $item->quantity);
        }
    }

    /**
     * Validate stock availability before creating order
     */
    private function validateStock(Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $variant = $item->productVariant;

            if (!$variant->is_available) {
                throw new Exception("{$variant->product->name} ({$variant->color} - {$variant->size}) is not available");
            }

            if ($variant->stock < $item->quantity) {
                throw new Exception(
                    "Insufficient stock for {$variant->product->name} ({$variant->color} - {$variant->size}). Available: {$variant->stock}"
                );
            }
        }
    }

    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal(Cart $cart): float
    {
        return $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Calculate total weight
     */
    private function calculateTotalWeight(Cart $cart): int
    {
        return $cart->items->sum(function ($item) {
            return $item->productVariant->product->weight * $item->quantity;
        });
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber(): string
    {
        $prefix = 'DZ';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));

        return "{$prefix}{$date}{$random}";
    }

    /**
     * Get valid status transitions
     */
    private function getValidStatusTransitions(): array
    {
        return [
            'pending_payment' => ['pending_verification', 'cancelled'],
            'pending_verification' => ['verified', 'rejected', 'cancelled'],
            'verified' => ['processing'],
            'processing' => ['shipped'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
            'rejected' => [],
        ];
    }
}