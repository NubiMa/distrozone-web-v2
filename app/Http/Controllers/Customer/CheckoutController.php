<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;
    protected ShippingService $shippingService;

    public function __construct(
        CartService $cartService,
        OrderService $orderService,
        ShippingService $shippingService
    ) {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->shippingService = $shippingService;
    }

    /**
     * Tampilkan halaman checkout
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        
        // Ambil data keranjang dari database
        $cart = $this->cartService->getCartSummary($userId);

        if (empty($cart['items']) || $cart['total_items'] === 0) {
            return redirect()->route('customer.cart')
                ->with('error', 'Keranjang belanja kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        // Ambil alamat customer
        $addresses = CustomerAddress::where('user_id', $userId)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil alamat default atau alamat pertama
        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();

        // Hitung ongkir jika ada alamat
        $shipping = null;
        if ($defaultAddress) {
            try {
                $totalWeight = $this->calculateTotalWeight($cart['items']);
                $shipping = $this->shippingService->calculateShippingCost(
                    $defaultAddress->city,
                    $defaultAddress->province,
                    $totalWeight
                );
            } catch (\Exception $e) {
                $shipping = [
                    'error' => $e->getMessage(),
                    'shipping_cost' => 0,
                ];
            }
        }

        // Hitung total
        $subtotal = $cart['subtotal'];
        $shippingCost = $shipping['shipping_cost'] ?? 0;
        $total = $subtotal + $shippingCost;

        return view('customer.checkout', compact(
            'cart',
            'addresses',
            'defaultAddress',
            'shipping',
            'subtotal',
            'shippingCost',
            'total'
        ));
    }

    /**
     * Proses pemesanan
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:customer_addresses,id',
            'catatan' => 'nullable|string|max:500',
        ], [
            'address_id.required' => 'Silakan pilih alamat pengiriman.',
            'address_id.exists' => 'Alamat tidak valid.',
        ]);

        $userId = $request->user()->id;

        // Validasi bahwa alamat milik customer ini
        $address = CustomerAddress::where('id', $validated['address_id'])
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return back()->with('error', 'Alamat tidak valid.');
        }

        // Cek jam operasional (10:00 - 17:00)
        $currentHour = (int) now()->format('H');
        if ($currentHour < 10 || $currentHour >= 17) {
            return back()->with('error', 'Maaf, pemesanan online hanya dapat dilakukan pada jam 10:00 - 17:00.');
        }

        try {
            $order = $this->orderService->createOrderFromCart(
                $userId,
                $validated['address_id'],
                $validated['catatan'] ?? null
            );

            return redirect()
                ->route('customer.orders.show', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Hitung total berat dari item keranjang
     */
    private function calculateTotalWeight(array|\Illuminate\Support\Collection $items): int
    {
        $totalWeight = 0;
        foreach ($items as $item) {
            // Asumsi berat per item adalah 300 gram (default untuk kaos)
            $weight = $item['weight'] ?? 300;
            $totalWeight += $weight * $item['quantity'];
        }
        return $totalWeight;
    }
}
