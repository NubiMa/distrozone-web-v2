<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Sales report
     */
    public function sales(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $orders = Order::with(['items', 'user', 'payment'])
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered'])
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total');
        $totalProfit = $orders->sum(function ($order) {
            return $order->getTotalProfit();
        });

        // Group by date
        $dailySales = $orders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d');
        })->map(function ($dayOrders) {
            return [
                'orders' => $dayOrders->count(),
                'revenue' => $dayOrders->sum('total'),
                'profit' => $dayOrders->sum(function ($order) {
                    return $order->getTotalProfit();
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'total_orders' => $totalOrders,
                    'total_revenue' => $totalRevenue,
                    'total_profit' => $totalProfit,
                    'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
                ],
                'daily_breakdown' => $dailySales,
                'orders' => $orders,
            ],
        ]);
    }

    /**
     * Revenue report
     */
    public function revenue(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_by' => 'sometimes|in:day,week,month',
        ]);

        $groupBy = $request->get('group_by', 'day');

        $query = Order::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered']);

        // Group by period
        $dateFormat = match ($groupBy) {
            'week' => '%Y-%U',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };

        $revenue = $query
            ->select(
                DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('SUM(subtotal) as product_revenue'),
                DB::raw('SUM(shipping_cost) as shipping_revenue')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $revenue,
        ]);
    }

    /**
     * Profit report
     */
    public function profit(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $orders = Order::with('items')
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered'])
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalCost = $orders->sum(function ($order) {
            return $order->items->sum(function ($item) {
                return $item->cost_price * $item->quantity;
            });
        });
        $totalProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'total_revenue' => $totalRevenue,
                'total_cost' => $totalCost,
                'total_profit' => $totalProfit,
                'profit_margin' => round($profitMargin, 2),
                'orders_count' => $orders->count(),
            ],
        ]);
    }

    /**
     * Best selling products
     */
    public function bestSellingProducts(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'limit' => 'sometimes|integer|min:1|max:100',
        ]);

        $query = OrderItem::with(['product', 'productVariant'])
            ->whereHas('order', function ($q) use ($validated) {
                $q->whereIn('status', ['verified', 'processing', 'shipped', 'delivered']);
                
                if (isset($validated['start_date'])) {
                    $q->whereDate('created_at', '>=', $validated['start_date']);
                }
                
                if (isset($validated['end_date'])) {
                    $q->whereDate('created_at', '<=', $validated['end_date']);
                }
            });

        $products = $query
            ->select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit($request->get('limit', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Low stock products
     */
    public function lowStock()
    {
        $products = ProductVariant::with(['product'])
            ->where('is_available', true)
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->get();

        $data = $products->map(function ($variant) {
            return [
                'product_id' => $variant->product_id,
                'product_name' => $variant->product->name,
                'variant_id' => $variant->id,
                'variant_sku' => $variant->sku,
                'color' => $variant->color,
                'size' => $variant->size,
                'current_stock' => $variant->stock,
                'min_stock' => $variant->min_stock,
                'status' => $variant->stock == 0 ? 'out_of_stock' : 'low_stock',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Export sales report
     */
    public function exportSales(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'sometimes|in:json,csv',
        ]);

        $orders = Order::with(['items', 'user', 'payment'])
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->whereIn('status', ['verified', 'processing', 'shipped', 'delivered'])
            ->get();

        $format = $request->get('format', 'json');

        if ($format === 'csv') {
            $csv = "Order Number,Date,Customer,Total,Status,Payment Status\n";
            
            foreach ($orders as $order) {
                $csv .= implode(',', [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->user->name,
                    $order->total,
                    $order->status,
                    $order->payment?->status ?? 'N/A',
                ]) . "\n";
            }

            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="sales-report.csv"');
        }

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }
}