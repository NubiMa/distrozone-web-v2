<x-layouts.guest>
    <x-slot:title>DistroZone - Streetwear Distro Terbaik</x-slot:title>

    <!-- Hero Section (Zalora-style full-width banner) -->
    <section class="relative bg-gray-50">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Text Content -->
                <div class="space-y-6">
                    <h1 class="font-display font-bold text-5xl md:text-6xl text-gray-800 leading-tight">
                        Best Fashion Sale
                        <span class="text-accent">Up to 70% Off</span>
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Koleksi kaos distro terbaru dengan desain eksklusif. Gratis ongkir untuk Jakarta & Depok.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('guest.catalog') }}"
                            class="inline-block bg-primary hover:bg-accent text-white font-semibold px-8 py-4 rounded-lg transition-fast">
                            Belanja Sekarang
                        </a>
                        <a href="{{ route('guest.about') }}"
                            class="inline-block border-2 border-primary hover:border-accent text-primary hover:text-accent font-semibold px-8 py-4 rounded-lg transition-fast">
                            Selengkapnya
                        </a>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-200">
                    <!-- Hero image placeholder -->
                    <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800" alt="Hero"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section (Zalora-style tiles) -->
    <section class="container mx-auto px-4 py-section">
        <div class="text-center mb-12">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-800 mb-4">
                Belanja Berdasarkan Kategori
            </h2>
            <p class="text-gray-600">Temukan koleksi kaos distro favoritmu</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <x-category-card :category="$category" />
            @empty
                <!-- Placeholder categories -->
                <div class="bg-bg-secondary rounded-lg p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-300 rounded-full mb-4"></div>
                    <p class="font-semibold">Basic Tees</p>
                </div>
                <div class="bg-bg-secondary rounded-lg p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-300 rounded-full mb-4"></div>
                    <p class="font-semibold">Graphic Tees</p>
                </div>
                <div class="bg-bg-secondary rounded-lg p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-300 rounded-full mb-4"></div>
                    <p class="font-semibold">Oversized</p>
                </div>
                <div class="bg-bg-secondary rounded-lg p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-300 rounded-full mb-4"></div>
                    <p class="font-semibold">Premium</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Feature Products Section -->
    <section class="bg-bg-secondary py-section">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-800 mb-2">
                        Produk Terbaru
                    </h2>
                    <p class="text-gray-600">Koleksi kaos distro pilihan</p>
                </div>
                <a href="{{ route('guest.catalog') }}"
                    class="text-accent hover:text-primary font-semibold flex items-center gap-2 transition-fast">
                    Lihat Semua
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Product Grid (Zalora-style 4 columns) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    @for ($i = 0; $i < 8; $i++)
                        <div class="bg-white border border-border rounded-lg overflow-hidden">
                            <div class="aspect-[3/4] bg-gray-200 animate-pulse"></div>
                            <div class="p-4 space-y-2">
                                <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                                <div class="h-6 bg-gray-200 rounded animate-pulse w-2/3"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- Promo Banner Section -->
    <section class="container mx-auto px-4 py-section">
        <div class="bg-primary rounded-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-12 items-center p-12">
                <div class="text-white space-y-6">
                    <h2 class="font-display font-bold text-4xl">
                        Dapatkan Diskon hingga <span class="text-accent">70%</span>
                    </h2>
                    <p class="text-gray-300 text-lg">
                        Khusus untuk member baru. Daftar sekarang dan nikmati penawaran eksklusif!
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-block bg-accent hover:bg-white hover:text-primary text-white font-semibold px-8 py-4 rounded-lg transition-fast">
                        Daftar Gratis
                    </a>
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-800">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600" alt="Promo"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-bg-secondary py-section">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="font-display font-bold text-3xl text-gray-800 mb-4">
                    Dapatkan Update Terbaru
                </h3>
                <p class="text-gray-600 mb-8">
                    Subscribe newsletter kami dan dapatkan info produk terbaru serta promo eksklusif
                </p>
                <form class="flex gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Email kamu..."
                        class="flex-1 px-6 py-4 rounded-full border border-border focus:outline-none focus:ring-2 focus:ring-accent">
                    <button type="submit"
                        class="bg-primary hover:bg-accent text-white font-semibold px-8 py-4 rounded-full transition-fast whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.guest>
