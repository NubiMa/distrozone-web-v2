@extends('layouts.customer')

@section('title', 'DistroZone - Style Masa Depan, Harga Teman')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-8 mb-8 border-4 border-black">
            <h1 class="text-5xl font-black italic mb-2">RIWAYAT BELANJA</h1>
            <p class="text-lg">Pantau status outfit yang sudah kamu cop. Jangan lupa pamerin di sosmed!</p>
            <div class="flex gap-4 mt-4">
                <button class="bg-black text-white px-6 py-2 font-bold border-2 border-white hover:bg-white hover:text-black transition">Support</button>
                <button class="bg-cyan-400 text-black px-6 py-2 font-bold border-2 border-black hover:bg-white transition">Belanja Lagi</button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-yellow-400 border-4 border-black p-6">
                <div class="flex items-center gap-4">
                    <span class="text-5xl">🚚</span>
                    <div>
                        <p class="text-sm font-bold">DALAM PENGIRIMAN</p>
                        <p class="text-4xl font-black">2</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-4 border-black p-6">
                <div class="flex items-center gap-4">
                    <span class="text-5xl">🛍️</span>
                    <div>
                        <p class="text-sm font-bold">TOTAL ORDER</p>
                        <p class="text-4xl font-black">24</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button class="bg-pink-500 text-white px-6 py-2 font-bold border-2 border-black">Semua</button>
            <button class="bg-white text-black px-6 py-2 font-bold border-2 border-black hover:bg-gray-100">Menunggu Pembayaran</button>
            <button class="bg-white text-black px-6 py-2 font-bold border-2 border-black hover:bg-gray-100">Diproses</button>
            <button class="bg-white text-black px-6 py-2 font-bold border-2 border-black hover:bg-gray-100">Dikirim</button>
            <button class="bg-white text-black px-6 py-2 font-bold border-2 border-black hover:bg-gray-100">Selesai</button>
        </div>

        <!-- Orders List -->
        <div class="space-y-6">

            <!-- Order 1 - Menunggu -->
            <div class="bg-white border-4 border-black p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-24881</p>
                        <p class="font-bold">14 Okt 2023</p>
                    </div>
                    <span class="bg-yellow-400 text-black px-4 py-1 font-bold border-2 border-black">MENUNGGU</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex -space-x-4">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                        <div class="w-16 h-16 border-2 border-black bg-gray-200 flex items-center justify-center font-bold">+1</div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black">Rp 450.000</p>
                    </div>
                    <a href="{{ route('customer.order.detail', 'DZ-24881') }}" class="bg-pink-500 text-white px-8 py-3 font-bold border-2 border-black hover:bg-pink-600 transition">
                        BAYAR SEKARANG →
                    </a>
                </div>
            </div>

            <!-- Order 2 - Diproses -->
            <div class="bg-white border-4 border-black p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-24872</p>
                        <p class="font-bold">10 Okt 2023</p>
                    </div>
                    <span class="bg-cyan-400 text-black px-4 py-1 font-bold border-2 border-black">DIPROSES</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black">Rp 125.000</p>
                    </div>
                    <a href="{{ route('customer.order.detail', 'DZ-24872') }}" class="bg-white text-black px-8 py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        LIHAT DETAIL
                    </a>
                </div>
            </div>

            <!-- Order 3 - Dikirim -->
            <div class="bg-white border-4 border-black p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-24801</p>
                        <p class="font-bold">08 Okt 2023</p>
                    </div>
                    <span class="bg-blue-500 text-white px-4 py-1 font-bold border-2 border-black">📦 DIKIRIM</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex -space-x-4">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black">Rp 550.000</p>
                    </div>
                    <a href="{{ route('customer.order.detail', 'DZ-24801') }}" class="bg-white text-black px-8 py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        LACAK PAKET
                    </a>
                </div>
            </div>

            <!-- Order 4 - Selesai -->
            <div class="bg-white border-4 border-black p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-24102</p>
                        <p class="font-bold">01 Sep 2023</p>
                    </div>
                    <span class="bg-green-500 text-white px-4 py-1 font-bold border-2 border-black">SELESAI</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black">Rp 200.000</p>
                    </div>
                    <button class="bg-white text-black px-8 py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        BELI LAGI
                    </button>
                </div>
            </div>

            <!-- Order 5 - Selesai -->
            <div class="bg-white border-4 border-black p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-23991</p>
                        <p class="font-bold">15 Aug 2023</p>
                    </div>
                    <span class="bg-green-500 text-white px-4 py-1 font-bold border-2 border-black">SELESAI</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex -space-x-4">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                        <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black">
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black">Rp 850.000</p>
                    </div>
                    <button class="bg-white text-black px-8 py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        BELI LAGI
                    </button>
                </div>
            </div>

            <!-- Order 6 - Dibatalkan -->
            <div class="bg-white border-4 border-black p-6 opacity-60">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600">#DZ-23500</p>
                        <p class="font-bold line-through">12 Jul 2023</p>
                    </div>
                    <span class="bg-black text-white px-4 py-1 font-bold border-2 border-black">DIBATALKAN</span>
                </div>

                <div class="flex gap-4 mb-4">
                    <img src="/api/placeholder/80/80" alt="Product" class="w-16 h-16 border-2 border-black grayscale">
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">TOTAL TAGIHAN</p>
                        <p class="text-2xl font-black line-through">Rp 50.000</p>
                    </div>
                    <button class="bg-white text-black px-8 py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        LIHAT DETAIL
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
