{{-- Modern Editorial Guest Navbar --}}
<header class="navbar-modern">
    <div class="editorial-container">
        <div class="flex items-center justify-between h-20">
            {{-- Logo/Brand --}}
            <a href="{{ route('guest.home') }}"
                class="font-display text-2xl font-bold tracking-tight hover:text-accent transition-colors duration-fast">
                DISTROZONE
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center gap-8 font-sans text-sm font-medium">
                <a href="{{ route('guest.home') }}" class="hover:text-accent transition-colors duration-fast">Home</a>
                <a href="{{ route('guest.catalog') }}"
                    class="hover:text-accent transition-colors duration-fast">Catalog</a>
                <a href="{{ route('guest.about') }}" class="hover:text-accent transition-colors duration-fast">About</a>
            </nav>

            {{-- Auth Links --}}
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('customer.home') }}" class="btn-minimal">
                        My Account
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-minimal">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        Register
                    </a>
                @endauth
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
                <a href="{{ route('guest.home') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Home</a>
                <a href="{{ route('guest.catalog') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">Catalog</a>
                <a href="{{ route('guest.about') }}"
                    class="text-sm font-medium hover:text-accent transition-colors">About</a>
                <div class="divider-modern my-2"></div>
                @auth
                    <a href="{{ route('customer.home') }}" class="btn-secondary text-center">My Account</a>
                @else
                    <a href="{{ route('login') }}" class="btn-minimal">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary text-center">Register</a>
                @endauth
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
