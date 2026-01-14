{{-- Brutalist Customer Catalog (same as guest but different routes) --}}
@extends('layouts.customer')

@section('title', 'CATALOG - DISTROZONE')

@section('content')
<div class="brutal-container py-8">
    {{-- Page Header --}}
    <div class="mb-8 brutal-border-b pb-6">
        <h1 class="font-display text-brutal-4xl font-bold uppercase tracking-tight mb-2">
            CATALOG
        </h1>
        <p class="font-mono text-sm text-gray-600 uppercase">
            {{ $products->total() }} ITEMS AVAILABLE
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Filter Sidebar --}}
        <aside class="lg:col-span-1">
            <div class="brutal-block bg-white p-6 sticky top-24">
                <h2 class="font-display text-lg font-bold uppercase tracking-tight mb-6 brutal-border-b pb-3">
                    FILTERS
                </h2>

                <form method="GET" action="{{ route('customer.catalog') }}">
                    {{-- Search --}}
                    <div class="mb-6">
                        <label class="brutal-label">SEARCH</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="PRODUCT NAME..."
                            class="brutal-input"
                        >
                    </div>

                    {{-- Type Filter --}}
                    <div class="mb-6">
                        <label class="brutal-label">TYPE</label>
                        <div class="space-y-2 font-mono text-sm">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="type[]" value="lengan pendek" {{ in_array('lengan pendek', request('type', [])) ? 'checked' : '' }} class="brutal-checkbox">
                                <span class="uppercase">SHORT SLEEVE</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="type[]" value="lengan panjang" {{ in_array('lengan panjang', request('type', [])) ? 'checked' : '' }} class="brutal-checkbox">
                                <span class="uppercase">LONG SLEEVE</span>
                            </label>
                        </div>
                    </div>

                    {{-- Size Filter --}}
                    <div class="mb-6">
                        <label class="brutal-label">SIZE</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] as $size)
                            <label class="brutal-block bg-white hover:bg-asphalt hover:text-white cursor-pointer p-2 text-center font-mono text-xs font-bold {{ in_array($size, request('size', [])) ? 'bg-asphalt text-white' : '' }}">
                                <input type="checkbox" name="size[]" value="{{ $size }}" class="sr-only" {{ in_array($size, request('size', [])) ? 'checked' : '' }}>
                                {{ $size }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="space-y-2">
                        <button type="submit" class="btn-brutal btn-brutal-sm w-full">
                            APPLY FILTERS
                        </button>
                        <a href="{{ route('customer.catalog') }}" class="btn-brutal btn-brutal-sm btn-brutal-secondary w-full text-center">
                            RESET
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <main class="lg:col-span-3">
            {{-- Sort Bar --}}
            <div class="flex items-center justify-between mb-6 brutal-border-b pb-4">
                <p class="font-mono text-sm uppercase text-gray-600">
                    SHOWING {{ $products->firstItem() }}-{{ $products->lastItem() }} OF {{ $products->total() }}
                </p>

                <form method="GET" action="{{ route('customer.catalog') }}" class="flex items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <select name="sort" onchange="this.form.submit()" class="brutal-select font-mono text-xs uppercase">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>NEWEST FIRST</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>PRICE: LOW-HIGH</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>PRICE: HIGH-LOW</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>NAME: A-Z</option>
                    </select>
                </form>
            </div>

            {{-- Products --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                @forelse($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full brutal-block bg-white p-12 text-center">
                        <p class="font-mono text-gray-600 uppercase mb-4">NO PRODUCTS FOUND</p>
                        <a href="{{ route('customer.catalog') }}" class="btn-brutal btn-brutal-sm">RESET FILTERS</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="flex items-center justify-center gap-2">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
