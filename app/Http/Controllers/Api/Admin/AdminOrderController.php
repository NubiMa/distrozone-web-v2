<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get all orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'payment']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Get single order
     */
    public function show(string $orderNumber)
    {
        $order = Order::with(['user', 'items.productVariant.product', 'payment', 'verifier'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'order' => $order,
                'profit' => $order->getTotalProfit(),
            ],
        ]);
    }

    /**
     * Update order
     */
    public function update(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $validated = $request->validate([
            'status' => 'sometimes|in:pending_payment,pending_verification,verified,processing,shipped,delivered,cancelled,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        if (isset($validated['status'])) {
            try {
                $this->orderService->updateOrderStatus(
                    $order,
                    $validated['status'],
                    $request->user()->id
                );
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }
        }

        if (isset($validated['admin_notes'])) {
            $order->admin_notes = $validated['admin_notes'];
            $order->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order->fresh(),
        ]);
    }

    /**
     * Add admin notes
     */
    public function addNotes(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $validated = $request->validate([
            'notes' => 'required|string',
        ]);

        $order->admin_notes = $validated['notes'];
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Notes added successfully',
        ]);
    }

    /**
     * Dashboard statistics
     */
    public function dashboardStats(Request $request)
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        // Today's stats
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered'])
            ->sum('total');

        // This month's stats
        $monthOrders = Order::whereDate('created_at', '>=', $thisMonth)->count();
        $monthRevenue = Order::whereDate('created_at', '>=', $thisMonth)
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered'])
            ->sum('total');

        // Pending counts
        $pendingVerification = Order::where('status', 'pending_verification')->count();
        $processing = Order::where('status', 'processing')->count();

        // Recent orders
        $recentOrders = Order::with(['user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'today' => [
                    'orders' => $todayOrders,
                    'revenue' => $todayRevenue,
                ],
                'this_month' => [
                    'orders' => $monthOrders,
                    'revenue' => $monthRevenue,
                ],
                'pending' => [
                    'verification' => $pendingVerification,
                    'processing' => $processing,
                ],
                'recent_orders' => $recentOrders,
            ],
        ]);
    }
}