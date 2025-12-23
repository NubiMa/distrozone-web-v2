<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CashierPaymentController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get all pending payments
     */
    public function pending(Request $request)
    {
        $payments = Payment::with(['order.user', 'order.items'])
            ->where('status', 'pending')
            ->whereHas('order', function ($q) {
                $q->where('status', 'pending_verification');
            })
            ->orderBy('proof_uploaded_at', 'asc')
            ->paginate(20);

        $data = $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'customer_name' => $payment->order->user->name,
                'amount' => $payment->amount,
                'proof_image' => $payment->proof_image_path,
                'sender_bank' => $payment->sender_bank_name,
                'sender_account_name' => $payment->sender_account_name,
                'sender_account_number' => $payment->sender_account_number,
                'uploaded_at' => $payment->proof_uploaded_at,
                'items_count' => $payment->order->items->count(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'total' => $payments->total(),
            ],
        ]);
    }

    /**
     * Verify payment
     */
    public function verify(Request $request, int $id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been processed',
            ], 400);
        }

        try {
            $order = $this->orderService->verifyPayment(
                $payment->order,
                $request->user()->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'data' => [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
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
     * Reject payment
     */
    public function reject(Request $request, int $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $payment = Payment::with('order')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been processed',
            ], 400);
        }

        try {
            $payment->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['reason'],
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
            ]);

            $this->orderService->updateOrderStatus(
                $payment->order,
                'rejected',
                $request->user()->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}