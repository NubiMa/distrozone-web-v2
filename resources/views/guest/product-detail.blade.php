<x-layouts.guest>
    <x-slot:title>{{ $product->name }} - DistroZone</x-slot:title>

    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-8">
                <ol class="flex items-center gap-2 text-text-secondary">
                    <li><a href="{{ route('guest.home') }}" class="hover:text-accent transition-fast">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('guest.catalog') }}" class="hover:text-accent transition-fast">Produk</a></li>
                    @if ($product->category)
                        <li>/</li>
                        <li><a href="{{ route('guest.catalog', ['category' => $product->category->slug]) }}"
                                class="hover:text-accent transition-fast">{{ $product->category->name }}</a></li>
                    @endif
                    <li>/</li>
                    <li class="text-gray-800 font-semibold">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <!-- Left: Image Gallery (Zalora style) -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4 aspect-[3/4] bg-bg-secondary rounded-lg overflow-hidden">
                        @if ($product->primaryImage)
                            <img id="mainImage" src="{{ Storage::url($product->primaryImage->image_path) }}"
                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $image)
                                <button onclick="changeMainImage('{{ Storage::url($image->image_path) }}')"
                                    class="aspect-square rounded overflow-hidden border-2 {{ $image->is_primary ? 'border-accent' : 'border-transparent hover:border-gray-300' }} transition-fast">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right: Product Info -->
                <div>
                    <!-- Category Badge -->
                    @if ($product->category)
                        <div class="mb-2">
                            <span
                                class="inline-block text-xs uppercase tracking-wide text-text-secondary font-semibold">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    @endif

                    <!-- Product Name -->
                    <h1 class="font-display font-bold text-3xl md:text-4xl mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-accent font-bold text-3xl">
                            Rp {{ number_format($product->base_price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Stock Info -->
                    @if ($product->getTotalStock() > 0)
                        <p class="text-sm text-green-600 mb-6">
                            ✓ Stok tersedia ({{ $product->getTotalStock() }} pcs)
                        </p>
                    @else
                        <p class="text-sm text-red-500 mb-6">
                            ✗ Stok habis
                        </p>
                    @endif

                    <hr class="border-border mb-6">

                    <!-- Color Selector -->
                    @if ($product->variants->pluck('color')->unique()->count() > 1)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-3 uppercase tracking-wide">Pilih Warna</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->variants->pluck('color')->unique() as $color)
                                    <button
                                        class="px-4 py-2 border-2 border-border hover:border-accent text-sm font-semibold rounded transition-fast">
                                        {{ $color }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Size Selector -->
                    @if ($product->variants->pluck('size')->unique()->count() > 1)
                        <div class="mb-8">
                            <label class="block text-sm font-semibold mb-3 uppercase tracking-wide">Pilih Ukuran</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->variants->pluck('size')->unique()->sort() as $size)
                                    <button
                                        class="px-5 py-3 border-2 border-border hover:border-accent text-sm font-bold rounded transition-fast">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="space-y-3 mb-8">
                        <!-- Login required for guest -->
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-primary hover:bg-accent text-white font-bold py-4 rounded-lg transition-fast">
                            Login untuk Membeli
                        </a>
                        <a href="{{ route('login') }}"
                            class="block w-full text-center border-2 border-primary hover:border-accent hover:text-accent text-primary font-bold py-4 rounded-lg transition-fast">
                            Tambah ke Wishlist
                        </a>
                    </div>

                    <hr class="border-border mb-8">

                    <!-- Product Description -->
                    <div>
                        <h3 class="font-display font-bold text-lg mb-4">Deskripsi Produk</h3>
                        <div class="text-gray-600 leading-relaxed space-y-2">
                            {{ $product->description ?? 'Tidak ada deskripsi tersedia.' }}
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-8 bg-bg-secondary rounded-lg p-6 space-y-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm">Garansi 100% Original</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm">Gratis Ongkir Jakarta & Depok</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm">Bisa COD atau Transfer Bank</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <section class="mt-16">
                    <h2 class="font-display font-bold text-2xl mb-8">Produk Serupa</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function changeMainImage(imageUrl) {
                document.getElementById('mainImage').src = imageUrl;
            }
        </script>
    @endpush
</x-layouts.guest>
