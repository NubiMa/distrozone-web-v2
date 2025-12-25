{{-- resources/views/customer/cart.blade.php --}}
@extends('layouts.customer')

@section('title', 'Keranjang Belanja - DistroZone')

@section('content')
<div class="px-6 py-8">
    
    {{-- Page Header --}}
    <div class="bg-gradient-to-r from-blue-400 to-cyan-400 border-4 border-black rounded-2xl p-8 mb-8 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h1 class="text-5xl font-black italic mb-2">KERANJANG KAMU</h1>
        <p class="text-lg">Ready to look cool today?</p>
    </div>

    @if($cartItems->isEmpty())
        {{-- Empty Cart --}}
        <div class="bg-white border-4 border-black rounded-2xl p-16 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <div class="w-32 h-32 bg-gray-100 border-3 border-black rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black mb-2">Keranjang Kosong</h3>
            <p class="text-gray-600 mb-6">Yuk, mulai belanja sekarang!</p>
            <a href="{{ route('customer.catalog') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-pink-600 text-white font-bold border-3 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex items-start gap-6">
                        {{-- Product Image --}}
                        <div class="w-24 h-24 bg-gray-100 border-3 border-black rounded-xl overflow-hidden flex-shrink-0">
                            <img 
                                src="{{ $item->productVariant->product->primaryImage?->image_path ? asset('storage/' . $item->productVariant->product->primaryImage->image_path) : asset('images/placeholder.png') }}" 
                                alt="{{ $item->productVariant->product->name }}"
                                class="w-full h-full object-cover"
                            >
                        </div>

                        {{-- Product Info --}}
                        <div class="flex-1">
                            <h3 class="text-lg font-black mb-1">{{ $item->productVariant->product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">
                                Size: {{ $item->productVariant->size }} • {{ $item->productVariant->color }}
                            </p>

                            {{-- Quantity Controls --}}
                            <div class="flex items-center gap-3">
                                <div class="flex items-center border-3 border-black rounded-full overflow-hidden shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    <button 
                                        onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                        class="w-10 h-10 flex items-center justify-center bg-white hover:bg-gray-50 transition font-bold"
                                    >
                                        −
                                    </button>
                                    <span class="w-12 h-10 flex items-center justify-center font-bold bg-gray-50">
                                        {{ $item->quantity }}
                                    </span>
                                    <button 
                                        onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                        class="w-10 h-10 flex items-center justify-center bg-white hover:bg-gray-50 transition font-bold"
                                    >
                                        +
                                    </button>
                                </div>

                                <p class="text-sm text-gray-500">
                                    IDR {{ number_format($item->price, 0, ',', '.') }} / item
                                </p>
                            </div>
                        </div>

                        {{-- Price & Delete --}}
                        <div class="text-right">
                            <p class="text-2xl font-black text-pink-600 mb-4">
                                IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </p>
                            
                            <button 
                                onclick="removeItem({{ $item->id }})"
                                class="w-10 h-10 border-3 border-black rounded-full flex items-center justify-center hover:bg-pink-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Free Shipping Promo --}}
                @if($subtotal < 500000)
                <div class="bg-gradient-to-r from-blue-100 to-cyan-100 border-4 border-black rounded-2xl p-6 flex items-center gap-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="w-12 h-12 bg-blue-400 border-3 border-black rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold">
                            Gratis ongkir untuk pembelian di atas IDR 500.000. Tambah 
                            <span class="text-pink-600">IDR {{ number_format(500000 - $subtotal, 0, ',', '.') }}</span> lagi!
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] sticky top-6">
                    <h3 class="text-lg font-black mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Ringkasan
                    </h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Total Harga ({{ $cartItems->sum('quantity') }} Barang)</span>
                            <span class="font-bold">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between text-green-600">
                            <span class="text-sm">Diskon Barang</span>
                            <span class="font-bold">-IDR 0</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Ongkos Kirim</span>
                            <span class="font-bold">IDR {{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Biaya Layanan</span>
                            <span class="font-bold">IDR {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Voucher Input --}}
                    <div class="mb-6">
                        <p class="text-xs font-bold mb-2 uppercase">Punya Kode Voucher?</p>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                placeholder="KODEPROMO"
                                class="flex-1 px-4 py-2 border-3 border-black rounded-xl font-medium uppercase placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-600"
                            >
                            <button class="px-6 py-2 bg-black text-white font-bold border-3 border-black rounded-xl hover:bg-gray-800 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                Pakai
                            </button>
                        </div>
                    </div>

                    <div class="border-t-3 border-black pt-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold">Total Tagihan</span>
                            <span class="text-2xl font-black text-pink-600">
                                IDR {{ number_format($subtotal + $shipping + $serviceFee, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('customer.checkout') }}" class="block w-full px-6 py-4 bg-pink-600 text-white text-center font-black border-3 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                        LANJUTKAN KE CHECKOUT →
                    </a>

                    <p class="text-xs text-center text-gray-500 mt-4">
                        Transaksi aman & terenkripsi
                    </p>

                    {{-- Payment Methods --}}
                    <div class="flex items-center justify-center gap-3 mt-4">
                        <div class="px-3 py-1 border-2 border-gray-300 rounded-lg text-xs font-bold text-gray-500">VISA</div>
                        <div class="px-3 py-1 border-2 border-gray-300 rounded-lg text-xs font-bold text-gray-500">MC</div>
                        <div class="px-3 py-1 border-2 border-gray-300 rounded-lg text-xs font-bold text-gray-500">QRIS</div>
                        <div class="px-3 py-1 border-2 border-gray-300 rounded-lg text-xs font-bold text-gray-500">BANK</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) {
        if (confirm('Hapus item dari keranjang?')) {
            removeItem(itemId);
        }
        return;
    }
    
    fetch(`/customer/cart/items/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal mengupdate keranjang');
        }
    })
    .catch(err => alert('Terjadi kesalahan'));
}

function removeItem(itemId) {
    fetch(`/customer/cart/items/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal menghapus item');
        }
    })
    .catch(err => alert('Terjadi kesalahan'));
}
</script>
@endpush
@endsection