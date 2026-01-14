<x-layouts.customer>
    <x-slot:title>Wishlist - DistroZone</x-slot:title>

    <div class="bg-bg-secondary min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="font-display font-bold text-3xl">Wishlist Saya</h1>
                <p class="text-text-secondary">{{ $wishlistItems->count() }} produk</p>
            </div>

            @if ($wishlistItems->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($wishlistItems as $item)
                        <div class="bg-white rounded-lg overflow-hidden shadow-card group">
                            <!-- Product Image -->
                            <div class="relative aspect-[3/4] bg-bg-secondary overflow-hidden">
                                @if ($item->product->primaryImage)
                                    <img src="{{ Storage::url($item->product->primaryImage->image_path) }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Remove Button -->
                                <button onclick="removeFromWishlist({{ $item->id }})"
                                    class="absolute top-2 right-2 bg-white hover:bg-red-50 text-red-500 p-2 rounded-full shadow-md transition-fast">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>

                                <!-- Stock Badge -->
                                @if ($item->product->getTotalStock() <= 0)
                                    <div
                                        class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        SOLD OUT
                                    </div>
                                @elseif($item->product->getTotalStock() < 5)
                                    <div
                                        class="absolute top-2 left-2 bg-accent text-white text-xs font-bold px-2 py-1 rounded">
                                        STOK TERBATAS
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-sm mb-1 line-clamp-2">{{ $item->product->name }}</h3>

                                @if ($item->product->category)
                                    <p class="text-text-secondary text-xs mb-2">{{ $item->product->category->name }}</p>
                                @endif

                                <p class="text-accent font-bold text-lg mb-3">
                                    Rp {{ number_format($item->product->base_price, 0, ',', '.') }}
                                </p>

                                <!-- Actions -->
                                @if ($item->product->getTotalStock() > 0)
                                    <a href="{{ route('customer.product-detail', $item->product->slug) }}"
                                        class="block w-full bg-primary hover:bg-accent text-white text-center text-sm font-semibold py-2 rounded transition-fast">
                                        Lihat Detail
                                    </a>
                                @else
                                    <button disabled
                                        class="block w-full bg-gray-300 text-gray-500 text-center text-sm font-semibold py-2 rounded cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($wishlistItems->hasPages())
                    <div class="mt-8">
                        {{ $wishlistItems->links() }}
                    </div>
                @endif
            @else
                <!-- Empty Wishlist State -->
                <div class="bg-white rounded-lg p-12 text-center shadow-card max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h2 class="font-display font-bold text-2xl mb-2">Wishlist Kosong</h2>
                    <p class="text-text-secondary mb-6">Belum ada produk favorit yang kamu simpan</p>
                    <a href="{{ route('customer.catalog') }}"
                        class="inline-block bg-primary hover:bg-accent text-white font-semibold px-8 py-3 rounded-lg transition-fast">
                        Jelajahi Produk
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function removeFromWishlist(wishlistId) {
                if (!confirm('Hapus produk dari wishlist?')) return;

                fetch(`/customer/wishlist/${wishlistId}`, {
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
                            alert(data.message || 'Gagal menghapus dari wishlist');
                        }
                    });
            }
        </script>
    @endpush
</x-layouts.customer>
