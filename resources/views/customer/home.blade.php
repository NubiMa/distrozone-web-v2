<x-layouts.customer>
    <x-slot:title>Home - DistroZone</x-slot:title>

    <!-- Same content as guest home, but with customer layout for logged-in users -->

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-50 to-white py-20">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="font-display font-bold text-5xl md:text-6xl mb-6 leading-tight">
                        Best Fashion Sale <span class="text-accent">Up to 70% Off</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Koleksi kaos distro terbaru dengan desain eksklusif. Gratis ongkir untuk Jakarta & Depok.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('customer.catalog') }}"
                            class="bg-primary hover:bg-accent text-white font-bold px-8 py-4 rounded-lg transition-fast">
                            Belanja Sekarang
                        </a>
                        <a href="{{ route('customer.catalog') }}"
                            class="border-2 border-primary hover:border-accent hover:text-accent text-primary font-bold px-8 py-4 rounded-lg transition-fast">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/5] bg-primary rounded-2xl overflow-hidden shadow-xl">
                        <img src="https://images.unsplash.com/photo-1574190919809-38ddfcb6a1bf?w=800" alt="Hero"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="font-display font-bold text-3xl mb-8">Kategori</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <x-category-card :category="$category" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-bg-secondary">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-display font-bold text-3xl">Produk Unggulan</h2>
                <a href="{{ route('customer.catalog') }}"
                    class="text-accent hover:text-primary font-semibold transition-fast">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" :authenticated="true" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-20 bg-primary text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="font-display font-bold text-4xl mb-4">Gratis Ongkir Jakarta & Depok</h2>
            <p class="text-gray-300 text-lg mb-8">Belanja sekarang dan nikmati free shipping untuk wilayah Jakarta dan
                Depok</p>
            <a href="{{ route('customer.catalog') }}"
                class="inline-block bg-accent hover:bg-white hover:text-primary text-white font-bold px-8 py-4 rounded-lg transition-fast">
                Mulai Belanja
            </a>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-2xl text-center">
            <h2 class="font-display font-bold text-3xl mb-4">Tetap Update dengan Koleksi Terbaru</h2>
            <p class="text-gray-600 mb-8">Dapatkan info promo dan koleksi terbaru langsung ke email kamu</p>
            <form class="flex gap-4">
                <input type="email" placeholder="Email kamu"
                    class="flex-1 px-6 py-3 border border-border rounded-full focus:outline-none focus:ring-2 focus:ring-accent">
                <button type="submit"
                    class="bg-primary hover:bg-accent text-white font-bold px-8 py-3 rounded-full transition-fast">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
</x-layouts.customer>
