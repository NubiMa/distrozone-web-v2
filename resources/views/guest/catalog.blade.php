<x-layouts.guest>
    <x-slot:title>{{ isset($category) ? $category->name : 'Semua Produk' }} - DistroZone</x-slot:title>

    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Left Sidebar - Filters (Zalora style) -->
                <aside class="md:col-span-1">
                    <div class="bg-white sticky top-24">
                        <!-- Filter Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-display font-bold text-lg">Filter</h3>
                            <a href="{{ route('guest.catalog') }}"
                                class="text-sm text-text-secondary hover:text-accent transition-fast">
                                Reset
                            </a>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-6 pb-6 border-b border-border">
                            <h4 class="font-semibold text-sm mb-3 uppercase tracking-wide">Kategori</h4>
                            <div class="space-y-2">
                                <a href="{{ route('guest.catalog') }}"
                                    class="block text-sm {{ !request('category') ? 'text-accent font-semibold' : 'text-gray-600 hover:text-accent' }} transition-fast">
                                    Semua Produk
                                </a>
                                @foreach ($categories as $cat)
                                    <a href="{{ route('guest.catalog', ['category' => $cat->slug]) }}"
                                        class="block text-sm {{ request('category') === $cat->slug ? 'text-accent font-semibold' : 'text-gray-600 hover:text-accent' }} transition-fast">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="mb-6 pb-6 border-b border-border">
                            <h4 class="font-semibold text-sm mb-3 uppercase tracking-wide">Harga</h4>
                            <div class="space-y-2">
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-accent cursor-pointer transition-fast">
                                    <input type="checkbox" class="mr-2 rounded">
                                    Di bawah Rp 100.000
                                </label>
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-accent cursor-pointer transition-fast">
                                    <input type="checkbox" class="mr-2 rounded">
                                    Rp 100.000 - Rp 200.000
                                </label>
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-accent cursor-pointer transition-fast">
                                    <input type="checkbox" class="mr-2 rounded">
                                    Di atas Rp 200.000
                                </label>
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-sm mb-3 uppercase tracking-wide">Ukuran</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                    <button
                                        class="px-4 py-2 border border-border hover:border-accent hover:text-accent text-sm font-semibold rounded transition-fast">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content - Product Grid -->
                <main class="md:col-span-3">
                    <!-- Breadcrumb & Sorting Bar (Zalora style) -->
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-border">
                        <div>
                            <h1 class="font-display font-bold text-2xl mb-1">
                                {{ isset($category) ? $category->name : 'Semua Produk' }}
                            </h1>
                            <p class="text-sm text-text-secondary">
                                {{ $products->total() }} produk ditemukan
                            </p>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="flex items-center gap-4">
                            <label class="text-sm text-gray-600">Urutkan:</label>
                            <select
                                class="px-4 py-2 border border-border rounded focus:outline-none focus:ring-2 focus:ring-accent text-sm">
                                <option>Terbaru</option>
                                <option>Harga: Rendah ke Tinggi</option>
                                <option>Harga: Tinggi ke Rendah</option>
                                <option>Nama: A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Grid (Zalora 3-column) -->
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @forelse($products as $product)
                            <x-product-card :product="$product" />
                        @empty
                            <div class="col-span-full text-center py-16">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="font-display font-semibold text-xl mb-2">Produk Tidak Ditemukan</h3>
                                <p class="text-text-secondary mb-4">Coba filter yang berbeda atau cek kategori lain</p>
                                <a href="{{ route('guest.catalog') }}"
                                    class="inline-block bg-primary hover:bg-accent text-white font-semibold px-6 py-3 rounded transition-fast">
                                    Lihat Semua Produk
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-layouts.guest>
