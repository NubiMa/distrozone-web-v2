{{-- resources/views/customer/home.blade.php --}}
@extends('layouts.customer')

@section('title', 'DistroZone - Style Masa Depan, Harga Teman')

@section('content')
<div class="px-6 py-8">
    
    {{-- Hero Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        {{-- Main Hero --}}
        <div class="lg:col-span-2">
            <div class="relative bg-gradient-to-br from-gray-800 to-gray-600 border-4 border-black rounded-3xl overflow-hidden shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] h-[500px]">
                <img 
                    src="{{ asset('images/hero-model.jpg') }}" 
                    alt="Hero Model" 
                    class="w-full h-full object-cover opacity-90"
                >
                
                {{-- Overlay Content --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-8">
                    <span class="inline-block px-4 py-1 bg-pink-600 text-white text-xs font-bold border-2 border-white rounded-full mb-4 w-fit shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        NEW DROP 2024
                    </span>
                    
                    <h1 class="text-5xl font-black text-white mb-2">
                        STYLE MASA DEPAN
                    </h1>
                    <h2 class="text-5xl font-black text-blue-400 mb-4">
                        HARGA TEMAN
                    </h2>
                    
                    <p class="text-white text-lg mb-6 max-w-lg">
                        Koleksi Y2K Terbatas. Estetika retro-futuristik untuk gen-z yang berani beda.
                    </p>
                    
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-black font-bold border-3 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Cek Katalog
                    </a>
                </div>
            </div>
        </div>

        {{-- Side Promotions --}}
        <div class="flex flex-col gap-6">
            {{-- Flash Sale --}}
            <div class="relative bg-gradient-to-br from-blue-400 to-blue-500 border-4 border-black rounded-3xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] h-[240px] flex flex-col justify-between">
                <div class="absolute top-4 right-4 w-16 h-16 bg-pink-600 rounded-full border-3 border-black"></div>
                
                <div>
                    <h3 class="text-3xl font-black text-white italic mb-2">
                        FLASH<br>SALE
                    </h3>
                    <span class="inline-block px-3 py-1 bg-white text-black text-sm font-bold border-2 border-black rounded-full">
                        Diskon 50%
                    </span>
                </div>
                
                <div class="flex justify-center">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                    </svg>
                </div>
            </div>

            {{-- Member Promo --}}
            <div class="bg-gradient-to-br from-green-100 to-green-200 border-4 border-black rounded-3xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] h-[240px] flex flex-col justify-center text-center">
                <p class="text-sm font-bold text-gray-600 mb-2">MEMBER BARU?</p>
                <h3 class="text-4xl font-black text-pink-600 mb-2">GRATIS</h3>
                <p class="text-lg font-bold text-gray-800">ONGKIR</p>
            </div>
        </div>
    </div>

    {{-- Scrolling Marquee --}}
    <div class="bg-black border-4 border-black rounded-2xl py-4 mb-12 overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <div class="flex items-center gap-8 text-white font-bold text-sm animate-marquee whitespace-nowrap">
            <span class="flex items-center gap-2">⭐ NEW ARRIVALS</span>
            <span class="flex items-center gap-2">⭐ FREE SHIPPING</span>
            <span class="flex items-center gap-2">⭐ LIMITED EDITION</span>
            <span class="flex items-center gap-2">⭐ Y2K VIBES</span>
            <span class="flex items-center gap-2">⭐ DISTROZONE ORIGINAL</span>
            <span class="flex items-center gap-2">⭐ NEW ARRIVALS</span>
            <span class="flex items-center gap-2">⭐ FREE SHIPPING</span>
            <span class="flex items-center gap-2">⭐ NEW ARRIVALS</span>
            <span class="flex items-center gap-2">⭐ FREE SHIPPING</span>
            <span class="flex items-center gap-2">⭐ LIMITED EDITION</span>
            <span class="flex items-center gap-2">⭐ Y2K VIBES</span>
            <span class="flex items-center gap-2">⭐ DISTROZONE ORIGINAL</span>
            <span class="flex items-center gap-2">⭐ NEW ARRIVALS</span>
            <span class="flex items-center gap-2">⭐ FREE SHIPPING</span>
        </div>
    </div>

    {{-- Category Section --}}
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black flex items-center gap-2">
                <span class="text-pink-600">🏷️</span>
                KATEGORI PILIHAN
            </h2>
            <a href="{{ route('catalog') }}" class="text-sm font-bold text-pink-600 hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(['KAOS' => 'bg-pink-100', 'HOODIES' => 'bg-blue-100', 'OUTERWEAR' => 'bg-green-100', 'AKSESORIS' => 'bg-yellow-100'] as $category => $color)
            <a href="{{ route('catalog', ['category' => strtolower($category)]) }}" class="group">
                <div class="{{ $color }} border-4 border-black rounded-2xl p-8 flex flex-col items-center justify-center gap-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 h-40">
                    <div class="w-16 h-16 bg-white border-3 border-black rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-black">{{ $category }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- New Drops Section --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black flex items-center gap-2">
                <span class="text-blue-400">🆕</span>
                NEW DROPS
            </h2>
            <a href="{{ route('catalog', ['filter' => 'new']) }}" class="text-sm font-bold text-pink-600 hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($newProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">Belum ada produk baru</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

@push('styles')
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        animation: marquee 20s linear infinite;
    }
</style>
@endpush
@endsection