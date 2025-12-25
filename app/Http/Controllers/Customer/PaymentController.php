<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\BankAccount;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get active bank accounts
     */
    public function bankAccounts()
    {
        $banks = BankAccount::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banks,
        ]);
    }

    /**
     * Upload payment proof
     */
    public function uploadProof(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (!$order->isPendingPayment()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment proof cannot be uploaded for this order',
            ], 400);
        }

        $validated = $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'sender_bank_name' => 'required|string|max:255',
            'sender_account_name' => 'required|string|max:255',
            'sender_account_number' => 'required|string|max:255',
        ]);

        try {
            // Store payment proof image
            $proofPath = $request->file('proof_image')->store('payment-proofs', 'public');

            // Create or update payment record
            $payment = Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => 'bank_transfer',
                    'amount' => $order->total,
                    'proof_image_path' => $proofPath,
                    'proof_uploaded_at' => now(),
                    'sender_bank_name' => $validated['sender_bank_name'],
                    'sender_account_name' => $validated['sender_account_name'],
                    'sender_account_number' => $validated['sender_account_number'],
                    'status' => 'pending',
                ]
            );

            // Update order status
            $this->orderService->updateOrderStatus($order, 'pending_verification');

            return response()->json([
                'success' => true,
                'message' => 'Payment proof uploaded successfully',
                'data' => [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'payment_status' => $payment->status,
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
     * Get payment details
     */
    public function show(Request $request, string $orderNumber)
    {
        $order = Order::with('payment')
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (!$order->payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'payment_method' => $order->payment->payment_method,
                'amount' => $order->payment->amount,
                'status' => $order->payment->status,
                'proof_uploaded_at' => $order->payment->proof_uploaded_at,
                'verified_at' => $order->payment->verified_at,
                'rejection_reason' => $order->payment->rejection_reason,
                'sender_bank_name' => $order->payment->sender_bank_name,
                'sender_account_name' => $order->payment->sender_account_name,
            ],
        ]);
    }
}