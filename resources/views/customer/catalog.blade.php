{{-- resources/views/customer/catalog.blade.php --}}
@extends('layouts.customer')

@section('title', 'Katalog Produk - DistroZone')

@section('content')
<div class="px-6 py-8">
    
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black mb-2">KATALOG PRODUK</h1>
        <p class="text-gray-600">Temukan gaya Y2K & Streetwear terbaikmu di sini.</p>
    </div>

    {{-- Filters & Products Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        {{-- Sidebar Filter --}}
        <div class="lg:col-span-1">
            <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] sticky top-6">
                
                {{-- Filter Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Filter
                    </h3>
                    <button class="text-sm font-bold text-pink-600 hover:underline">RESET</button>
                </div>

                <form action="{{ route('catalog') }}" method="GET" class="space-y-6">
                    
                    {{-- Price Range --}}
                    <div>
                        <h4 class="text-sm font-bold mb-3 uppercase">Rentang Harga</h4>
                        <div class="space-y-2">
                            <input 
                                type="range" 
                                name="max_price" 
                                min="50000" 
                                max="500000" 
                                step="10000"
                                value="{{ request('max_price', 500000) }}"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-pink-600"
                            >
                            <div class="flex items-center justify-between text-sm font-medium">
                                <span>Rp 50rb</span>
                                <span>Rp {{ number_format(request('max_price', 500000) / 1000, 0) }}rb</span>
                            </div>
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <h4 class="text-sm font-bold mb-3 uppercase">Kategori</h4>
                        <div class="space-y-3">
                            @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="category" 
                                    value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'checked' : '' }}
                                    class="w-5 h-5 border-2 border-black rounded-full text-pink-600 focus:ring-pink-600 cursor-pointer"
                                >
                                <span class="text-sm font-medium group-hover:text-pink-600 transition">
                                    {{ $category->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Size Filter --}}
                    <div>
                        <h4 class="text-sm font-bold mb-3 uppercase">Ukuran</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="sizes[]" value="{{ $size }}" class="peer hidden">
                                <span class="inline-block px-4 py-2 border-3 border-black rounded-lg font-bold text-sm peer-checked:bg-pink-600 peer-checked:text-white hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    {{ $size }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Apply Button --}}
                    <x-button type="submit" variant="primary" size="md" :fullWidth="true">
                        Terapkan Filter
                    </x-button>
                </form>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="lg:col-span-3">
            
            {{-- Toolbar --}}
            <div class="flex items-center justify-between mb-6 bg-white border-3 border-black rounded-xl p-4 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-bold">
                        Menampilkan <span class="text-pink-600">{{ $products->count() }}</span> produk
                    </span>
                    
                    {{-- Quick Filters --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('catalog', ['filter' => 'new']) }}" class="px-3 py-1 bg-blue-400 text-white text-xs font-bold border-2 border-black rounded-full hover:bg-blue-500 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            NEW DROP
                        </a>
                        <a href="{{ route('catalog', ['filter' => 'sale']) }}" class="px-3 py-1 bg-pink-600 text-white text-xs font-bold border-2 border-black rounded-full hover:bg-pink-700 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            SALE
                        </a>
                    </div>
                </div>

                {{-- Sort Dropdown --}}
                <div class="relative">
                    <select 
                        name="sort" 
                        onchange="window.location.href='{{ route('catalog') }}?sort='+this.value"
                        class="px-4 py-2 border-3 border-black rounded-lg font-bold text-sm appearance-none pr-10 cursor-pointer shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:outline-none focus:ring-2 focus:ring-pink-600"
                    >
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                @forelse($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-3 text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 border-3 border-black rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-gray-600 mb-4">Coba ubah filter atau kata kunci pencarian</p>
                        <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-pink-600 text-white font-bold border-3 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                            Reset Filter
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="flex items-center justify-center gap-2">
                {{-- Previous --}}
                @if($products->onFirstPage())
                    <span class="px-4 py-2 border-3 border-gray-300 rounded-lg font-bold text-gray-400 cursor-not-allowed">
                        ←
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 border-3 border-black rounded-lg font-bold hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        ←
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <span class="px-4 py-2 bg-pink-600 text-white border-3 border-black rounded-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 border-3 border-black rounded-lg font-bold hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 border-3 border-black rounded-lg font-bold hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        →
                    </a>
                @else
                    <span class="px-4 py-2 border-3 border-gray-300 rounded-lg font-bold text-gray-400 cursor-not-allowed">
                        →
                    </span>
                @endif
            </div>
            @endif

        </div>
    </div>

</div>
@endsection