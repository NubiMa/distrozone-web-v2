<x-layouts.customer>
    <x-slot:title>Keranjang Belanja - DistroZone</x-slot:title>

    <div class="bg-bg-secondary min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <h1 class="font-display font-bold text-3xl mb-8">Keranjang Belanja</h1>

            @if ($cart && $cart->items->count() > 0)
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Cart Items (Left - 2 columns) -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cart->items as $item)
                            <div class="bg-white rounded-lg p-6 shadow-card">
                                <div class="flex gap-6">
                                    <!-- Product Image -->
                                    <div class="w-24 h-24 flex-shrink-0">
                                        @if ($item->productVariant->product->primaryImage)
                                            <img src="{{ Storage::url($item->productVariant->product->primaryImage->image_path) }}"
                                                alt="{{ $item->productVariant->product->name }}"
                                                class="w-full h-full object-cover rounded">
                                        @else
                                            <div
                                                class="w-full h-full bg-bg-secondary rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg mb-1">
                                            {{ $item->productVariant->product->name }}</h3>
                                        <p class="text-text-secondary text-sm mb-2">
                                            {{ $item->productVariant->color }} / {{ $item->productVariant->size }}
                                        </p>
                                        <p class="text-accent font-bold text-lg">
                                            Rp
                                            {{ number_format($item->productVariant->product->base_price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex flex-col items-end justify-between">
                                        <button onclick="removeFromCart({{ $item->id }})"
                                            class="text-gray-400 hover:text-red-500 transition-fast">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <div class="flex items-center gap-2 border border-border rounded">
                                            <button
                                                onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                class="px-3 py-1 hover:bg-bg-secondary transition-fast"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="px-4 font-semibold">{{ $item->quantity }}</span>
                                            <button
                                                onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                class="px-3 py-1 hover:bg-bg-secondary transition-fast"
                                                {{ $item->quantity >= $item->productVariant->stock ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>

                                        @if ($item->quantity >= $item->productVariant->stock)
                                            <p class="text-red-500 text-xs">Stok maksimal</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary (Right - 1 column, Sticky) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg p-6 shadow-card sticky top-24">
                            <h2 class="font-display font-bold text-xl mb-6">Ringkasan Belanja</h2>

                            <!-- Summary Items -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-text-secondary">Total Produk ({{ $cart->items->sum('quantity') }}
                                        items)</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($cart->items->sum(fn($item) => $item->quantity * $item->productVariant->product->base_price), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-text-secondary">Ongkir</span>
                                    <span class="text-gray-600">Dihitung di checkout</span>
                                </div>
                            </div>

                            <hr class="border-border mb-6">

                            <!-- Total -->
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-bold text-lg">Total</span>
                                <span class="font-bold text-2xl text-accent">
                                    Rp
                                    {{ number_format($cart->items->sum(fn($item) => $item->quantity * $item->productVariant->product->base_price), 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('customer.checkout') }}"
                                class="block w-full bg-primary hover:bg-accent text-white text-center font-bold py-4 rounded-lg transition-fast mb-3">
                                Lanjut ke Checkout
                            </a>

                            <a href="{{ route('customer.catalog') }}"
                                class="block w-full text-center text-gray-600 hover:text-accent text-sm transition-fast">
                                ← Lanjut Belanja
                            </a>

                            <!-- Promo Info -->
                            <div class="mt-6 p-4 bg-accent bg-opacity-10 rounded-lg">
                                <p class="text-sm text-gray-800">
                                    🚚 <strong>Gratis Ongkir</strong> untuk Jakarta & Depok
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="bg-white rounded-lg p-12 text-center shadow-card max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="font-display font-bold text-2xl mb-2">Keranjang Kosong</h2>
                    <p class="text-text-secondary mb-6">Belum ada produk di keranjang kamu</p>
                    <a href="{{ route('customer.catalog') }}"
                        class="inline-block bg-primary hover:bg-accent text-white font-semibold px-8 py-3 rounded-lg transition-fast">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function updateQuantity(itemId, newQuantity) {
                if (newQuantity < 1) return;

                fetch(`/customer/cart/${itemId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal update quantity');
                        }
                    });
            }

            function removeFromCart(itemId) {
                if (!confirm('Hapus produk dari keranjang?')) return;

                fetch(`/customer/cart/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menghapus item');
                        }
                    });
            }
        </script>
    @endpush
</x-layouts.customer>
