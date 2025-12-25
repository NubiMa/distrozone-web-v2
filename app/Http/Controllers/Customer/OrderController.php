<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get customer orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.productVariant.product', 'payment'])
            ->where('user_id', $request->user()->id);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $query->orderBy('created_at', 'desc');

        $orders = $query->paginate(10);

        $data = $orders->map(function ($order) {
            return [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => $order->total,
                'items_count' => $order->items->count(),
                'payment_status' => $order->payment?->status,
                'created_at' => $order->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    /**
     * Create new order from cart
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:customer_addresses,id',
            'customer_notes' => 'nullable|string|max:500',
        ]);

        try {
            $order = $this->orderService->createOrderFromCart(
                $request->user()->id,
                $validated['address_id'],
                $validated['customer_notes'] ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'status' => $order->status,
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get order details
     */
    public function show(Request $request, string $orderNumber)
    {
        $order = Order::with(['items.productVariant.product', 'payment'])
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'subtotal' => $order->subtotal,
                'shipping_cost' => $order->shipping_cost,
                'total' => $order->total,
                'items' => $order->items->map(fn($item) => [
                    'product_name' => $item->product_name,
                    'sku' => $item->product_sku,
                    'color' => $item->variant_color,
                    'size' => $item->variant_size,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]),
                'shipping' => [
                    'recipient_name' => $order->recipient_name,
                    'recipient_phone' => $order->recipient_phone,
                    'address' => $order->shipping_address,
                    'city' => $order->city,
                    'province' => $order->province,
                    'postal_code' => $order->postal_code,
                ],
                'payment' => $order->payment ? [
                    'status' => $order->payment->status,
                    'amount' => $order->payment->amount,
                    'proof_uploaded' => $order->payment->proof_image_path !== null,
                    'verified_at' => $order->payment->verified_at,
                ] : null,
                'customer_notes' => $order->customer_notes,
                'created_at' => $order->created_at,
                'verified_at' => $order->verified_at,
                'shipped_at' => $order->shipped_at,
                'delivered_at' => $order->delivered_at,
            ],
        ]);
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (!$order->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled at this stage',
            ], 400);
        }

        try {
            $this->orderService->updateOrderStatus($order, 'cancelled');

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}