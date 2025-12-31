<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class UploadProofController extends Controller
{
    public function uploadProof($orderId)
    {
        $order = Order::where('id', $orderId)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        return view('customer.upload-proof', compact('order'));
    }

    public function storeProof(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $order = Order::where('id', $orderId)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');

            // Save the file path to the order
            $order->payment_proof = $filePath;
            $order->status = 'payment_under_review'; // Update status accordingly
            $order->save();
        }

        return redirect()->route('orders.show', $order->order_number)
                         ->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
