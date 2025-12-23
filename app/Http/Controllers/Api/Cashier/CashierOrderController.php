<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CashierOrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get all orders for cashier
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'payment']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Get pending orders (waiting for verification)
     */
    public function pending()
    {
        $orders = Order::with(['user', 'payment'])
            ->where('status', 'pending_verification')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Get single order details
     */
    public function show(string $orderNumber)
    {
        $order = Order::with(['user', 'items.productVariant.product', 'payment'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:processing,shipped,delivered',
        ]);

        try {
            $this->orderService->updateOrderStatus(
                $order,
                $validated['status'],
                $request->user()->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => [
                    'order_number' => $order->order_number,
                    'status' => $order->fresh()->status,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get cashier dashboard stats
     */
    public function stats(Request $request)
    {
        $today = now()->startOfDay();

        $pendingVerification = Order::where('status', 'pending_verification')->count();
        $processing = Order::where('status', 'processing')->count();
        
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayVerified = Order::whereDate('verified_at', $today)
            ->where('verified_by', $request->user()->id)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'pending_verification' => $pendingVerification,
                'processing' => $processing,
                'today_orders' => $todayOrders,
                'today_verified_by_me' => $todayVerified,
            ],
        ]);
    }
}