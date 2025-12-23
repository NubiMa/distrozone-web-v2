{{-- resources/views/guest/product-detail.blade.php --}}
@extends('layouts.guest')

@section('title', $product->name . ' - DistroZone')

@section('content')
<div class="px-6 py-8">
    
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm mb-6">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-pink-600">Katalog</a>
        <span class="text-gray-400">›</span>
        <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="text-gray-600 hover:text-pink-600">
            {{ $product->category->name }}
        </a>
        <span class="text-gray-400">›</span>
        <span class="font-bold">{{ $product->name }}</span>
    </nav>

    {{-- Product Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        
        {{-- Product Images --}}
        <div>
            <div class="bg-white border-4 border-black rounded-2xl overflow-hidden shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] mb-4">
                {{-- Badges --}}
                <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                    @if($product->is_featured)
                    <span class="px-3 py-1 bg-pink-600 text-white text-xs font-bold border-2 border-white rounded-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        BEST SELLER
                    </span>
                    @endif
                    
                    @if($product->created_at->isToday() || $product->created_at->isYesterday())
                    <span class="px-3 py-1 bg-blue-400 text-white text-xs font-bold border-2 border-white rounded-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        NEW DROP
                    </span>
                    @endif
                </div>

                {{-- Main Image --}}
                <div class="relative aspect-square bg-gray-100">
                    <img 
                        id="mainImage"
                        src="{{ $product->primaryImage?->image_path ? asset('storage/' . $product->primaryImage->image_path) : asset('images/placeholder.png') }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>

            {{-- Thumbnail Images --}}
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-3">
                @foreach($product->images as $image)
                <button 
                    onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                    class="aspect-square bg-white border-3 border-black rounded-xl overflow-hidden shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all"
                >
                    <img 
                        src="{{ asset('storage/' . $image->image_path) }}" 
                        alt="{{ $image->alt_text }}"
                        class="w-full h-full object-cover"
                    >
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            <h1 class="text-4xl font-black mb-2">{{ $product->name }}</h1>
            
            <div class="flex items-center gap-3 mb-6">
                <span class="text-3xl font-black text-pink-600">
                    Rp {{ number_format($product->base_price, 0, ',', '.') }}
                </span>
                @if($product->getLowestPrice() != $product->base_price)
                <span class="text-lg text-gray-400 line-through">
                    Rp {{ number_format($product->getHighestPrice(), 0, ',', '.') }}
                </span>
                @endif
            </div>

            {{-- Stock Badge --}}
            @if($product->getTotalStock() > 50)
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 border-3 border-black rounded-xl mb-6 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                <div class="w-2 h-2 bg-green-600 rounded-full animate-pulse"></div>
                <span class="text-sm font-bold text-green-800">Stok Tersedia: 50+</span>
            </div>
            @else
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 border-3 border-black rounded-xl mb-6 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                <div class="w-2 h-2 bg-yellow-600 rounded-full animate-pulse"></div>
                <span class="text-sm font-bold text-yellow-800">Stok Terbatas: {{ $product->getTotalStock() }}</span>
            </div>
            @endif

            {{-- Size Selector --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold uppercase">Pilih Ukuran</h3>
                    <button class="text-sm font-bold text-pink-600 hover:underline">Panduan Ukuran</button>
                </div>
                
                <div class="grid grid-cols-5 gap-3">
                    @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                    @php
                        $available = $product->variants->where('size', $size)->where('is_available', true)->sum('stock') > 0;
                    @endphp
                    <label class="cursor-pointer {{ !$available ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <input 
                            type="radio" 
                            name="size" 
                            value="{{ $size }}" 
                            class="peer hidden"
                            {{ !$available ? 'disabled' : '' }}
                        >
                        <div class="px-4 py-3 border-3 border-black rounded-xl font-bold text-center peer-checked:bg-pink-600 peer-checked:text-white hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            {{ $size }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Guest Login Prompt --}}
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 border-4 border-black rounded-2xl p-6 mb-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white border-3 border-black rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-black text-lg mb-1">INGIN MEMBELI PRODUK INI?</h3>
                        <p class="text-white text-sm">Bergabunglah dengan komunitas DistroZone untuk belanja, simpan wishlist, dan dapatkan promo eksklusif!</p>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('login') }}" class="flex-1 px-6 py-3 bg-white text-black text-center font-bold border-3 border-black rounded-xl hover:bg-gray-50 transition shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-1 px-6 py-3 bg-black text-white text-center font-bold border-3 border-white rounded-xl hover:bg-gray-800 transition shadow-[3px_3px_0px_0px_rgba(255,255,255,1)]">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

            {{-- Product Description --}}
            <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <h3 class="text-lg font-black mb-4 uppercase">Deskripsi</h3>
                <div class="text-gray-700 leading-relaxed mb-4">
                    {{ $product->description }}
                </div>
                
                <ul class="space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-pink-600 font-bold">•</span>
                        <span class="text-sm">100% Cotton Premium</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-pink-600 font-bold">•</span>
                        <span class="text-sm">Unisex Cut</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-pink-600 font-bold">•</span>
                        <span class="text-sm">Pre-shrunk fabric</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endpush
@endsection