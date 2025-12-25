{{-- resources/views/components/customer/navbar.blade.php --}}
<nav class="bg-white border-4 border-black rounded-full mx-6 my-4 px-8 py-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
    <div class="flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('customer.home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-pink-600 rounded-full border-3 border-black flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <span class="text-xl font-bold italic">DISTROZONE</span>
        </a>

        {{-- Navigation Menu --}}
        <div class="flex items-center gap-8">
            <a href="{{ route('customer.home') }}" class="text-base font-medium hover:text-pink-600 transition">
                Beranda
            </a>
            <a href="{{ route('customer.catalog') }}" class="text-base font-medium hover:text-pink-600 transition">
                Katalog
            </a>
            <a href="{{ route('customer.about') }}" class="text-base font-medium hover:text-pink-600 transition">
                Tentang
            </a>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3">
            {{-- Wishlist --}}
            <a href="#" class="relative w-11 h-11 border-3 border-black rounded-full flex items-center justify-center hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </a>

            {{-- Cart with Badge --}}
            <a href="{{ route('customer.cart') }}" class="relative w-11 h-11 bg-pink-600 border-3 border-black rounded-full flex items-center justify-center hover:bg-pink-700 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-400 border-2 border-black rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ auth()->user()->cart->items->count() }}
                </span>
                @endif
            </a>

            {{-- Profile Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 border-3 border-black rounded-full hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-blue-400 rounded-full border-2 border-black"></div>
                    <span class="text-sm font-bold">{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-3 w-64 bg-white border-4 border-black rounded-2xl shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden z-50">
                    <div class="p-4 bg-gradient-to-r from-pink-100 to-blue-100 border-b-3 border-black">
                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Status: Online</p>
                        <p class="font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="p-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-medium">Profil Akun</span>
                        </a>
                        
                        <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="font-medium">Riwayat Pesanan</span>
                        </a>
                        
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Alamat</span>
                        </a>
                    </div>
                    
                    <div class="p-2 border-t-3 border-black">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-pink-50 text-pink-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="font-bold">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@once
@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
@endonce