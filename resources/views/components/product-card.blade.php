{{-- resources/views/components/product-card.blade.php --}}
@props(['product'])

<div class="group relative">
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        <div class="bg-white border-4 border-black rounded-2xl overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
            {{-- Image Container --}}
            <div class="relative aspect-square bg-gray-100 overflow-hidden">
                <img 
                    src="{{ $product->primaryImage?->image_path ? asset('storage/' . $product->primaryImage->image_path) : asset('images/placeholder.png') }}" 
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover"
                >
                
                {{-- Badges --}}
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                    @if($product->is_featured)
                    <span class="px-3 py-1 bg-pink-600 text-white text-xs font-bold border-2 border-black rounded-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        BEST
                    </span>
                    @endif
                    
                    @if($product->created_at->isToday() || $product->created_at->isYesterday())
                    <span class="px-3 py-1 bg-blue-400 text-white text-xs font-bold border-2 border-black rounded-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        NEW
                    </span>
                    @endif
                </div>

                {{-- Wishlist Button (Guest can't use) --}}
                <button 
                    onclick="event.preventDefault(); alert('Silakan login untuk menambahkan ke wishlist');"
                    class="absolute top-3 right-3 w-10 h-10 bg-white border-3 border-black rounded-full flex items-center justify-center shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-pink-100 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>

            {{-- Product Info --}}
            <div class="p-4">
                {{-- Category --}}
                <p class="text-xs font-bold text-gray-500 uppercase mb-1">
                    {{ $product->category->name }}
                </p>

                {{-- Product Name --}}
                <h3 class="text-base font-bold mb-2 line-clamp-1">
                    {{ $product->name }}
                </h3>

                {{-- Price --}}
                <div class="flex items-center justify-between">
                    <p class="text-lg font-bold">
                        Rp {{ number_format($product->base_price, 0, ',', '.') }}
                    </p>

                    {{-- Quick View Button --}}
                    <button class="w-9 h-9 bg-blue-400 border-3 border-black rounded-full flex items-center justify-center shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>