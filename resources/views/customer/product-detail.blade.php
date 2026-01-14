{{-- Brutalist Customer Product Detail --}}
@extends('layouts.customer')

@section('title', $product->name . ' - DISTROZONE')

@section('content')
<div class="brutal-container py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 font-mono text-xs uppercase brutal-border-b pb-4 mb-8">
        <a href="{{ route('customer.home') }}" class="hover:text-accent transition-colors">HOME</a>
        <span>→</span>
        <a href="{{ route('customer.catalog') }}" class="hover:text-accent transition-colors">CATALOG</a>
        <span>→</span>
        <span class="font-bold">{{ $product->merek_kaos }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        {{-- Product Image --}}
        <div>
            <div class="brutal-block aspect-square bg-stone">
                @if($product->primaryImage)
                    <img 
                        src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="font-display text-6xl font-bold text-gray-400">NO IMAGE</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div>
            {{-- Brand/Name --}}
            <h1 class="font-display text-brutal-5xl font-bold uppercase tracking-tight mb-6 leading-none">
                {{ $product->name }}
            </h1>

            {{-- Price --}}
            <div class="mb-8">
                <p class="font-mono text-6xl font-bold text-accent mb-2">
                    {{ number_format($product->base_price, 0, ',', '.') }}
                </p>
                <p class="font-mono text-sm text-gray-600 uppercase">INDONESIAN RUPIAH</p>
            </div>

            {{-- Product Specs --}}
            <div class="brutal-block bg-white p-6 mb-8 font-mono text-sm">
                <table class="w-full">
                    <tr class="brutal-border-b">
                        <td class="py-3 font-bold uppercase">SKU</td>
                        <td class="py-3 text-right">{{ $product->sku }}</td>
                    </tr>
                    <tr class="brutal-border-b">
                        <td class="py-3 font-bold uppercase">CATEGORY</td>
                        <td class="py-3 text-right">{{ $product->category->name ?? 'N/A' }}</td>
                    </tr>
                    <tr class="brutal-border-b">
                        <td class="py-3 font-bold uppercase">WEIGHT</td>
                        <td class="py-3 text-right">{{ $product->weight }}g</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-bold uppercase">STOCK</td>
                        <td class="py-3 text-right">
                            @php $totalStock = $product->getTotalStock(); @endphp
                            @if($totalStock > 10)
                                <span class="text-asphalt">{{ $totalStock }} UNITS</span>
                            @elseif($totalStock > 0)
                                <span class="text-accent">{{ $totalStock }} LEFT</span>
                            @else
                                <span class="text-gray-400">SOLD OUT</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Add to Cart Form --}}
            @if($product->getTotalStock() > 0)
                <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" class="mb-8">
                    @csrf
                    
                    {{-- Quantity Selector --}}
                    <div class="brutal-block bg-white p-6 mb-6">
                        <label class="brutal-label mb-4">QUANTITY</label>
                        <div class="flex items-center gap-4">
                            <button type="button" onclick="decrementQty()" class="brutal-block bg-white hover:bg-asphalt hover:text-white transition-colors w-12 h-12 flex items-center justify-center font-display text-2xl font-bold">
                                −
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->getTotalStock() }}" class="brutal-input text-center font-mono text-2xl font-bold w-24">
                            <button type="button" onclick="incrementQty({{ $product->getTotalStock() }})" class="brutal-block bg-white hover:bg-asphalt hover:text-white transition-colors w-12 h-12 flex items-center justify-center font-display text-2xl font-bold">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="btn-brutal btn-brutal-lg">
                            ADD TO CART
                        </button>
                        <button type="button" onclick="addToWishlist({{ $product->id }})" class="btn-brutal btn-brutal-lg btn-brutal-secondary">
                            WISHLIST
                        </button>
                    </div>
                </form>
            @else
                <div class="brutal-block bg-asphalt text-white p-8 mb-8 text-center">
                    <p class="font-display text-brutal-2xl font-bold uppercase">SOLD OUT</p>
                    <p class="font-mono text-sm mt-2">THIS ITEM IS CURRENTLY UNAVAILABLE</p>
                </div>
            @endif

            {{-- Product Details --}}
            <div class="brutal-block bg-white p-6">
                <h3 class="font-display text-lg font-bold uppercase tracking-tight mb-4 brutal-border-b pb-3">
                    PRODUCT INFO
                </h3>
                <ul class="space-y-2 font-mono text-sm">
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">■</span>
                        <span>100% PREMIUM COTTON</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">■</span>
                        <span>SCREEN PRINTED GRAPHICS</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">■</span>
                        <span>PRE-SHRUNK FABRIC</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">■</span>
                        <span>UNISEX FIT</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">■</span>
                        <span>MADE IN INDONESIA</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function incrementQty(max) {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

async function addToWishlist(productId) {
    try {
        const response = await fetch(`/customer/wishlist/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        alert(data.message || 'Added to wishlist');
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add to wishlist');
    }
}
</script>
@endpush
@endsection
