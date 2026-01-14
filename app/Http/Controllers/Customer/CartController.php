<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Tampilkan keranjang belanja
     */
    public function index(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart($request->user()->id);
        
        // Load items with product and variant relationships
        $cart->load(['items.productVariant.product.primaryImage']);

        return view('customer.cart', compact('cart'));
    }

    /**
     * Tambah item ke keranjang (dari halaman produk)
     * Route: POST /customer/cart/add/{id} (product_id)
     */
    public function add(Request $request, int $id)
    {
        $validated = $request->validate([
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ], [
            'color.required' => 'Silakan pilih warna.',
            'size.required' => 'Silakan pilih ukuran.',
            'quantity.required' => 'Jumlah harus diisi.',
            'quantity.min' => 'Jumlah minimal 1.',
        ]);

        // Cari variant berdasarkan product_id, color, dan size
        $variant = ProductVariant::where('product_id', $id)
            ->where('color', $validated['color'])
            ->where('size', $validated['size'])
            ->where('is_available', true)
            ->first();

        if (!$variant) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Varian produk tidak ditemukan atau tidak tersedia.',
                ], 404);
            }
            return back()->with('error', 'Varian produk tidak ditemukan atau tidak tersedia.');
        }

        try {
            $cartItem = $this->cartService->addItem(
                $request->user()->id,
                $variant->id,
                $validated['quantity']
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'data' => $cartItem,
                ], 201);
            }

            return redirect()->route('customer.cart')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update jumlah item di keranjang
     */
    public function updateQuantity(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $cartItem = $this->cartService->updateQuantity(
                $request->user()->id,
                $id,
                $validated['quantity']
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Keranjang berhasil diperbarui',
                    'data' => $cartItem,
                ]);
            }

            return back()->with('success', 'Keranjang berhasil diperbarui.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Hapus item dari keranjang
     */
    public function removeItem(Request $request, int $id)
    {
        try {
            $this->cartService->removeItem($request->user()->id, $id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang',
                ]);
            }

            return back()->with('success', 'Item berhasil dihapus dari keranjang.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Kosongkan keranjang
     */
    public function clear(Request $request)
    {
        $this->cartService->clearCart($request->user()->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan',
            ]);
        }

        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Ambil ringkasan keranjang (API)
     */
    public function summary(Request $request)
    {
        $summary = $this->cartService->getCartSummary($request->user()->id);

        return response()->json([
            'success' => true,
            'data' => $summary,
        ]);
    }
}

