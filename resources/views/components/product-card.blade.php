{{-- 
    Product Card Component - Zalora Layout + DistroZone Design System
    
    Props:
    - $product: Product model with image, name, price, category, etc.
    - $showWishlist: boolean (default: false for guest)
--}}

@props(['product', 'showWishlist' => false])

<div class="group relative bg-white border border-border rounded-lg overflow-hidden hover:shadow-card transition-base">
    <!-- Product Image (Portrait 3:4 ratio like Zalora) -->
    <div class="relative aspect-[3/4] overflow-hidden bg-bg-secondary">
        <a href="{{ route('guest.product', $product->id) }}">
            @if ($product->primaryImage)
                <img src="{{ Storage::url($product->primaryImage->image_path) }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-base">
            @else
                <!-- Placeholder -->
                <div class="w-full h-full flex items-center justify-center bg-bg-secondary">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </a>

        <!-- Badge (NEW / SALE) - Top Left -->
        @if ($product->is_featured)
            <div class="absolute top-3 left-3 bg-accent text-white text-xs font-semibold px-3 py-1 rounded">
                NEW
            </div>
        @endif

        <!-- Wishlist Heart - Bottom Right (only show for logged in users) -->
        @if ($showWishlist)
            <button type="button"
                class="absolute bottom-3 right-3 bg-white hover:bg-accent hover:text-white text-gray-800 p-2 rounded-full shadow-md transition-fast"
                onclick="toggleWishlist({{ $product->id }})">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <!-- Category (optional) -->
        @if (isset($product->category))
            <p class="text-text-secondary text-xs uppercase tracking-wide mb-1">
                {{ $product->category->name }}
            </p>
        @endif

        <!-- Product Name -->
        <a href="{{ route('guest.product', $product->id) }}" class="block">
            <h3 class="text-gray-800 font-semibold text-base mb-2 line-clamp-2 group-hover:text-accent transition-fast">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Price -->
        <div class="flex items-baseline gap-2 mb-3">
            <span class="text-accent font-bold text-lg">
                Rp {{ number_format($product->base_price, 0, ',', '.') }}
            </span>
            <!-- Old Price if on sale -->
            @if (isset($product->old_price) && $product->old_price > $product->base_price)
                <span class="text-text-secondary text-sm line-through">
                    Rp {{ number_format($product->old_price, 0, ',', '.') }}
                </span>
            @endif
        </div>

        <!-- Stock Info -->
        @if ($product->getTotalStock() > 0)
            <p class="text-xs text-gray-600 mb-3">
                Stok: {{ $product->getTotalStock() }} pcs
            </p>
        @else
            <p class="text-xs text-red-500 mb-3">
                Stok Habis
            </p>
        @endif

        <!-- Add to Cart Button -->
        <a href="{{ route('guest.product', $product->id) }}"
            class="block w-full text-center bg-primary hover:bg-accent text-white font-semibold py-2.5 rounded transition-fast">
            Lihat Detail
        </a>
    </div>
</div>

@push('scripts')
    <script>
        function toggleWishlist(productId) {
            @auth
            // AJAX call to toggle wishlist
            fetch('/customer/wishlist/toggle/' + productId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI (could add filled heart animation)
                        location.reload();
                    }
                });
        @else
            window.location.href = '{{ route('login') }}';
        @endauth
        }
    </script>
@endpush
