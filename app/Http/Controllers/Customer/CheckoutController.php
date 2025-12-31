<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = session()->get('cart', []);

        if(empty($cartItems)) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang kosong');
        }

        $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $ongkir = 20000;
        $biayaLayanan = 1000;
        $total = $subtotal + $ongkir + $biayaLayanan;

        return view('customer.checkout', compact('cartItems', 'subtotal', 'ongkir', 'biayaLayanan', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'courier' => 'required',
            'payment_method' => 'required'
        ]);

        // Simpan order ke database (sesuaikan dengan model Order Anda)
        $orderId = 'DZ-' . date('Y') . '-' . str_pad(rand(1, 9999), 3, '0', STR_PAD_LEFT);

        session()->forget('cart');

        return redirect()->route('customer.order.detail', $orderId)->with('success', 'Pesanan berhasil dibuat');
    }
}
