{{-- resources/views/components/guest/navbar.blade.php --}}
<nav class="bg-white border-4 border-black rounded-full mx-6 my-4 px-8 py-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
    <div class="flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-pink-600 rounded-full border-3 border-black flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <span class="text-xl font-bold">DistroZone</span>
        </a>

        {{-- Navigation Menu --}}
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-base font-medium hover:text-pink-600 transition">
                Beranda
            </a>
            <a href="{{ route('catalog') }}" class="text-base font-medium hover:text-pink-600 transition">
                Katalog
            </a>
            <a href="{{ route('about') }}" class="text-base font-medium hover:text-pink-600 transition">
                Tentang
            </a>
        </div>

        {{-- Auth Buttons --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-6 py-2 border-3 border-black rounded-full font-medium hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="px-6 py-2 bg-pink-600 text-white border-3 border-black rounded-full font-medium hover:bg-pink-700 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                Daftar
            </a>
        </div>
    </div>
</nav>  