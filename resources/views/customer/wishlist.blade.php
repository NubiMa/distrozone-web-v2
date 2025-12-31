@extends('layouts.customer')

@section('title', 'DistroZone - Style Masa Depan, Harga Teman')

@section('content')

<div class="min-h-screen bg-black text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-6xl font-black italic mb-2" style="font-style: italic;">MY STASH</h1>
            <p class="text-xl text-gray-300">Your curated collection of Y2K heat. Keep it locked or cop it now.</p>
        </div>

        <!-- Filter -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-2">
                <button class="bg-pink-500 text-white px-6 py-2 font-bold border-2 border-white">Newest ▼</button>
                <button class="bg-white text-black px-6 py-2 font-bold border-2 border-white hover:bg-gray-200 transition">Price: Low-High</button>
                <button class="bg-white text-black px-6 py-2 font-bold border-2 border-white hover:bg-gray-200 transition">In Stock</button>
            </div>
        </div>

        @if(empty($wishlistItems))
            <div class="text-center py-20">
                <span class="text-8xl mb-4 block">💔</span>
                <p class="text-2xl font-bold mb-4">Wishlist kamu masih kosong</p>
                <p class="text-gray-400 mb-6">Mulai koleksi item favoritmu sekarang!</p>
                <a href="/katalog" class="inline-block bg-pink-500 text-white px-8 py-3 font-bold border-4 border-white hover:bg-pink-600 transition">
                    Jelajahi Katalog
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Item 1 - New Drop -->
                <div class="bg-gray-900 border-4 border-white relative group">
                    <div class="absolute top-3 left-3 z-10">
                        <span class="bg-cyan-400 text-black px-3 py-1 font-bold text-xs">NEW DROP</span>
                    </div>

                    <form action="{{ route('customer.wishlist.remove', '1') }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Cyber-Goth Tee V2" class="w-full h-80 object-cover border-b-4 border-white">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1">CYBER-GOTH TEE V2</h3>
                        <p class="text-sm text-gray-400 mb-2">Cotton • Oversized</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-500 text-black px-2 py-1 text-xs font-bold">IN STOCK</span>
                        </div>

                        <p class="text-pink-500 font-black text-2xl mb-3">Rp 150.000</p>

                        <button class="w-full bg-pink-500 text-white py-3 font-bold border-2 border-white hover:bg-white hover:text-black transition flex items-center justify-center gap-2">
                            🛒 Add
                        </button>
                    </div>
                </div>

                <!-- Item 2 - Low Stock -->
                <div class="bg-gray-900 border-4 border-white relative group">
                    <div class="absolute top-3 left-3 z-10">
                        <span class="bg-yellow-400 text-black px-3 py-1 font-bold text-xs">LOW STOCK</span>
                    </div>

                    <form action="{{ route('customer.wishlist.remove', '2') }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Neo-Punk Hoodie" class="w-full h-80 object-cover border-b-4 border-white">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1">NEO-PUNK HOODIE</h3>
                        <p class="text-sm text-gray-400 mb-2">Fleece • Heavyweight</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-yellow-400 text-black px-2 py-1 text-xs font-bold">LOW STOCK</span>
                        </div>

                        <p class="text-pink-500 font-black text-2xl mb-3">Rp 350.000</p>

                        <button class="w-full bg-cyan-400 text-black py-3 font-bold border-2 border-white hover:bg-white transition flex items-center justify-center gap-2">
                            🛒 Add
                        </button>
                    </div>
                </div>

                <!-- Item 3 - In Stock -->
                <div class="bg-gray-900 border-4 border-white relative group">
                    <form action="{{ route('customer.wishlist.remove', '3') }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Digital Cargo Pants" class="w-full h-80 object-cover border-b-4 border-white">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1">DIGITAL CARGO PANTS</h3>
                        <p class="text-sm text-gray-400 mb-2">Tech-wear • Black</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-500 text-black px-2 py-1 text-xs font-bold">IN STOCK</span>
                        </div>

                        <p class="text-pink-500 font-black text-2xl mb-3">Rp 250.000</p>

                        <button class="w-full bg-pink-500 text-white py-3 font-bold border-2 border-white hover:bg-white hover:text-black transition flex items-center justify-center gap-2">
                            🛒 Add
                        </button>
                    </div>
                </div>

                <!-- Item 4 - In Stock -->
                <div class="bg-gray-900 border-4 border-white relative group">
                    <form action="{{ route('customer.wishlist.remove', '4') }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Y2K Star Beanie" class="w-full h-80 object-cover border-b-4 border-white">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1">Y2K STAR BEANIE</h3>
                        <p class="text-sm text-gray-400 mb-2">Wool • One Size</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-500 text-black px-2 py-1 text-xs font-bold">IN STOCK</span>
                        </div>

                        <p class="text-pink-500 font-black text-2xl mb-3">Rp 75.000</p>

                        <button class="w-full bg-pink-500 text-white py-3 font-bold border-2 border-white hover:bg-white hover:text-black transition flex items-center justify-center gap-2">
                            🛒 Add
                        </button>
                    </div>
                </div>

                <!-- Item 5 - Sold Out -->
                <div class="bg-gray-900 border-4 border-white relative group opacity-60">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-10">
                        <span class="bg-black text-white px-6 py-3 font-black text-xl border-4 border-white">SOLD OUT</span>
                    </div>

                    <form action="{{ route('customer.wishlist.remove', '5') }}" method="POST" class="absolute top-3 right-3 z-20">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Retro Visor Shades" class="w-full h-80 object-cover border-b-4 border-white grayscale">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1 line-through">RETRO VISOR SHADES</h3>
                        <p class="text-sm text-gray-400 mb-2">Acrylic • UV400</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-gray-600 text-white px-2 py-1 text-xs font-bold">RESTOCKING SOON</span>
                        </div>

                        <p class="text-gray-500 font-black text-2xl mb-3 line-through">Rp 120.000</p>

                        <button class="w-full bg-gray-600 text-white py-3 font-bold border-2 border-white flex items-center justify-center gap-2" disabled>
                            🔔 Notify
                        </button>
                    </div>
                </div>

                <!-- Item 6 - In Stock -->
                <div class="bg-gray-900 border-4 border-white relative group">
                    <form action="{{ route('customer.wishlist.remove', '6') }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-xl hover:bg-red-500 hover:text-white transition">
                            ❤️
                        </button>
                    </form>

                    <img src="/api/placeholder/300/300" alt="Stomper Boots 3000" class="w-full h-80 object-cover border-b-4 border-white">

                    <div class="p-4">
                        <h3 class="font-black text-lg mb-1">STOMPER BOOTS 3000</h3>
                        <p class="text-sm text-gray-400 mb-2">Vegan Leather • 3" Sole</p>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-500 text-black px-2 py-1 text-xs font-bold">IN STOCK</span>
                        </div>

                        <p class="text-pink-500 font-black text-2xl mb-3">Rp 850.000</p>

                        <button class="w-full bg-pink-500 text-white py-3 font-bold border-2 border-white hover:bg-white hover:text-black transition flex items-center justify-center gap-2">
                            🛒 Add
                        </button>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>

<!-- Footer Section -->
<div class="bg-black text-white border-t-4 border-white py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-black italic mb-4">DISTROZONE</h2>
        <p class="text-gray-400 mb-8">Est. 2024. Providing the freshest Y2K gear for the modern web dweller.</p>

        <div class="flex justify-center items-center gap-8 mb-8">
            <div class="text-center">
                <p class="text-2xl font-black text-pink-500 mb-1">SHOP</p>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">New Arrivals</a>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">Best Sellers</a>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">Accessories</a>
            </div>

            <div class="text-center">
                <p class="text-2xl font-black text-pink-500 mb-1">SUPPORT</p>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">FAQ</a>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">Shipping</a>
                <a href="#" class="block text-sm hover:text-cyan-400 transition">Returns</a>
            </div>
        </div>

        <div class="flex justify-center gap-4 mb-4">
            <button class="bg-pink-500 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white hover:text-black transition">
                👍
            </button>
            <button class="bg-cyan-400 text-black w-12 h-12 rounded-full flex items-center justify-center hover:bg-white transition">
                💬
            </button>
            <button class="bg-yellow-400 text-black w-12 h-12 rounded-full flex items-center justify-center hover:bg-white transition">
                ✉️
            </button>
        </div>

        <p class="text-xs text-gray-600">© 2024 DISTROZONE POS SYSTEM. ALL RIGHTS RESERVED.</p>
    </div>
</div>

@endsection
