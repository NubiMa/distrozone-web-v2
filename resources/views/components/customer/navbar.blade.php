{{-- Modern Editorial Customer Navbar --}}
<header class="navbar-modern">
    <div class="editorial-container">
        <div class="flex items-center justify-between h-20">
            {{-- Logo/Brand --}}
            <a href="{{ route('customer.home') }}"
                class="font-display text-2xl font-bold tracking-tight hover:text-accent transition-colors duration-fast">
                DISTROZONE
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center gap-8 font-sans text-sm font-medium">
                <a href="{{ route('customer.home') }}" class="hover:text-accent transition-colors duration-fast">Home</a>
                <a href="{{ route('customer.catalog') }}"
                    class="hover:text-accent transition-colors duration-fast">Catalog</a>
                <a href="{{ route('customer.about') }}"
                    class="hover:text-accent transition-colors duration-fast">About</a>
            </nav>

            {{-- User Actions --}}
            <div class="hidden md:flex items-center gap-6">
                {{-- Wishlist --}}
                <a href="{{ route('customer.wishlist') }}" class="relative hover:text-accent transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </a>

                {{-- Cart --}}
                <a href="{{ route('customer.cart') }}" class="relative hover:text-accent transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-accent text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- User Menu --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="btn-minimal flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-modern shadow-lg py-2">
                        <a href="{{ route('customer.orders') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">My Orders</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50 transition-colors">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 hover:text-accent transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 py-4">
            <nav class="flex flex-col gap-4">
                <a href="{{ route('customer.home') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Home</a>
                <a href="{{ route('customer.catalog') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Catalog</a>
                <a href="{{ route('customer.about') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">About</a>
                <a href="{{ route('customer.cart') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Cart</a>
                <a href="{{ route('customer.wishlist') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Wishlist</a>
                <div class="divider-modern my-2"></div>
                <a href="{{ route('customer.orders') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">My Orders</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-secondary text-center w-full">Logout</button>
                </form>
            </nav>
        </div>
    </div>
</header>

@push('scripts')
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Add shadow on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-modern');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
@endpush

@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush
