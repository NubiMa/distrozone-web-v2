<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DistroZone - Streetwear Distro' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|space-grotesk:400,500,600,700"
        rel="stylesheet" />

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased bg-white">
    <!-- Top Bar (Zalora-style) -->
    <div class="bg-primary text-white text-xs py-2 border-b border-gray-800">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex gap-6">
                <span>🚚 Gratis Ongkir Jakarta & Depok</span>
                <span>🔥 Diskon s/d 70% - Koleksi Terbaru</span>
            </div>
            <div class="flex gap-4 text-gray-400">
                <a href="#" class="hover:text-accent transition-fast">Download App</a>
                <a href="#" class="hover:text-accent transition-fast">Bantuan</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-primary sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between gap-8">
                <!-- Logo -->
                <a href="{{ route('guest.home') }}" class="text-white font-display text-2xl font-bold tracking-tight">
                    DISTROZONE
                </a>

                <!-- Search Bar (Zalora-style capsule) -->
                <div class="flex-1 max-w-2xl">
                    <form action="{{ route('guest.catalog') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Cari produk distro..."
                            class="w-full px-6 py-3 rounded-full bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent transition-base">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white hover:bg-accent text-primary p-2 rounded-full transition-fast">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Action Icons -->
                <div class="flex items-center gap-6">
                    <!-- Login/Register for Guest -->
                    <a href="{{ route('login') }}"
                        class="text-border hover:text-accent transition-fast flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm">Login</span>
                    </a>

                    <!-- Cart Icon -->
                    <a href="{{ route('login') }}" class="text-border hover:text-accent transition-fast relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Navigation (Zalora-style) -->
        <nav class="border-t border-gray-800">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-center gap-8 py-4">
                    <a href="{{ route('guest.catalog') }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Semua Produk
                    </a>
                    <a href="{{ route('guest.catalog', ['category' => 'basic-tees']) }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Basic Tees
                    </a>
                    <a href="{{ route('guest.catalog', ['category' => 'graphic-tees']) }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Graphic Tees
                    </a>
                    <a href="{{ route('guest.catalog', ['category' => 'oversized']) }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Oversized
                    </a>
                    <a href="{{ route('guest.catalog', ['category' => 'premium']) }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Premium
                    </a>
                    <a href="{{ route('guest.about') }}"
                        class="text-border hover:text-accent uppercase text-sm font-semibold tracking-wider transition-fast">
                        Tentang
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-gray-400 mt-section">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <h3 class="text-white font-display text-xl font-bold mb-4">DISTROZONE</h3>
                    <p class="text-sm">
                        Streetwear distro dengan koleksi kaos distro terbaik. Jln. Raya Pegangsaan Timur No.29H, Kelapa
                        Gading, Jakarta.
                    </p>
                </div>

                <!-- Shop -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Belanja</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('guest.catalog') }}" class="hover:text-accent transition-fast">Semua
                                Produk</a></li>
                        <li><a href="{{ route('guest.catalog', ['category' => 'basic-tees']) }}"
                                class="hover:text-accent transition-fast">Basic Tees</a></li>
                        <li><a href="{{ route('guest.catalog', ['category' => 'graphic-tees']) }}"
                                class="hover:text-accent transition-fast">Graphic Tees</a></li>
                        <li><a href="{{ route('guest.catalog', ['category' => 'oversized']) }}"
                                class="hover:text-accent transition-fast">Oversized</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Informasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('guest.about') }}" class="hover:text-accent transition-fast">Tentang
                                Kami</a></li>
                        <li><a href="#" class="hover:text-accent transition-fast">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-accent transition-fast">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-accent transition-fast">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm">
                        <li>📞 081234567890</li>
                        <li>📧 info@distrozone.com</li>
                        <li class="pt-4">
                            <div class="flex gap-4">
                                <a href="#" class="hover:text-accent transition-fast">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                                <a href="#" class="hover:text-accent transition-fast">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} DistroZone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
