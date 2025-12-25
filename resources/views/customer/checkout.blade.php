{{-- resources/views/customer/checkout.blade.php --}}
@extends('layouts.customer')

@section('title', 'Checkout - DistroZone')

@section('content')
<div class="px-6 py-8">
    
    <div class="max-w-7xl mx-auto">
        
        {{-- Header --}}
        <h1 class="text-5xl font-black mb-8" style="font-style: italic;">CHECKOUT</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Shipping Information --}}
                <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex items-center gap-2 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h2 class="text-xl font-bold uppercase">Informasi Pengiriman</h2>
                    </div>

                    @if($selectedAddress)
                    <div class="border-3 border-dashed border-gray-300 rounded-xl p-4 mb-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold mb-1">{{ $selectedAddress->label ?? 'Alamat' }} - {{ $selectedAddress->recipient_name }}</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $selectedAddress->address }}, {{ $selectedAddress->city }}, {{ $selectedAddress->province }}, {{ $selectedAddress->postal_code }}
                                </p>
                            </div>
                            <a href="{{ route('customer.addresses') }}" class="text-sm font-bold text-blue-600 hover:underline">Ubah Alamat</a>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-black text-white text-xs font-bold rounded-full">UTAMA</span>
                            <span class="text-sm font-medium">{{ $selectedAddress->phone }}</span>
                        </div>
                    </div>
                    @else
                    <div class="border-3 border-dashed border-gray-300 rounded-xl p-6 text-center">
                        <p class="text-gray-600 mb-4">Belum ada alamat pengiriman</p>
                        <a href="{{ route('customer.addresses.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-pink-600 text-white font-bold border-3 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Alamat
                        </a>
                    </div>
                    @endif

                    {{-- Shipping Method --}}
                    <div class="mt-6">
                        <h3 class="text-sm font-bold mb-3 uppercase">Pilih Kurir</h3>
                        
                        <label class="block border-3 border-black rounded-xl p-4 mb-3 cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="shipping" value="jne" checked class="peer hidden">
                            <div class="flex items-center gap-4 peer-checked:font-bold">
                                <div class="w-16 h-16 bg-pink-600 border-3 border-black rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold text-xl">JNE</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold">JNE Reguler</h4>
                                    <p class="text-sm text-gray-600">Estimasi tiba: 2-3 Hari</p>
                                </div>
                                <span class="text-lg font-bold">Rp 20.000</span>
                            </div>
                        </label>

                        <label class="block border-3 border-gray-300 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="shipping" value="sicepat" class="peer hidden">
                            <div class="flex items-center gap-4 peer-checked:font-bold">
                                <div class="w-16 h-16 bg-purple-600 border-3 border-black rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">SiCepat</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold">SiCepat GOKIL</h4>
                                    <p class="text-sm text-gray-600">Estimasi tiba: 3-5 Hari</p>
                                </div>
                                <span class="text-lg font-bold">Rp 15.000</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex items-center gap-2 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <h2 class="text-xl font-bold uppercase">Metode Pembayaran</h2>
                    </div>

                    <div class="border-3 border-blue-200 bg-blue-50 rounded-xl p-4">
                        <div class="flex items-start gap-3 mb-4">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-blue-900 mb-1">Transfer Manual (Verifikasi Otomatis)</h3>
                                <p class="text-sm text-blue-800">Transfer ke rekening bank kami dan sistem akan memverifikasi otomatis</p>
                            </div>
                        </div>

                        {{-- Bank Accounts --}}
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($bankAccounts as $bank)
                            <div class="bg-white border-3 border-black rounded-xl p-4">
                                <div class="w-12 h-12 bg-blue-600 border-2 border-black rounded-lg flex items-center justify-center mb-3">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($bank->bank_name, 0, 3)) }}</span>
                                </div>
                                <p class="text-xs text-gray-600 mb-1">No. Rekening</p>
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-bold text-lg">{{ $bank->account_number }}</p>
                                    <button onclick="copyToClipboard('{{ $bank->account_number }}')" class="text-pink-600 hover:text-pink-700">
                                        <span class="text-xs font-bold">SALIN</span>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-600">a.n {{ $bank->account_holder_name }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 bg-yellow-100 border-3 border-yellow-600 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-yellow-800">
                            <strong>Mohon selesaikan pembayaran dalam waktu 1x24 jam</strong> setelah pesanan dibuat untuk menghindari pembatalan otomatis.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Right Column - Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] sticky top-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold uppercase">Ringkasan Pesanan</h3>
                        <span class="px-3 py-1 bg-black text-white text-xs font-bold rounded-full">{{ $cartItems->count() }} items</span>
                    </div>

                    {{-- Product List --}}
                    <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-100">
                            <div class="w-16 h-16 bg-gray-100 border-2 border-black rounded-lg overflow-hidden flex-shrink-0">
                                <img 
                                    src="{{ $item->productVariant->product->primaryImage ? asset('storage/' . $item->productVariant->product->primaryImage->image_path) : asset('images/placeholder.png') }}" 
                                    alt="{{ $item->productVariant->product->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm truncate">{{ $item->productVariant->product->name }}</h4>
                                <p class="text-xs text-gray-600">Size: {{ $item->productVariant->size }} | Color: {{ $item->productVariant->color }}</p>
                                <p class="text-sm font-bold text-pink-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-sm font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Promo Code --}}
                    <div class="mb-6">
                        <input 
                            type="text" 
                            placeholder="Kode Promo" 
                            class="w-full px-4 py-2 border-3 border-black rounded-xl font-medium mb-2 focus:outline-none focus:ring-2 focus:ring-pink-600"
                        >
                        <button class="w-full px-4 py-2 bg-white text-black font-bold border-3 border-black rounded-xl hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            Apply
                        </button>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span>Ongkos Kirim (JNE)</span>
                            <span class="font-bold">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span>Biaya Layanan</span>
                            <span class="font-bold">Rp 1.000</span>
                        </div>
                    </div>

                    <div class="border-t-2 border-black pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold uppercase">Total Bayar</span>
                            <span class="text-3xl font-black text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('customer.orders.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="address_id" value="{{ $selectedAddress->id ?? '' }}">
                        <input type="hidden" name="shipping_method" value="jne">
                        
                        <button type="submit" class="w-full px-6 py-4 bg-pink-600 text-white text-center font-bold border-3 border-black rounded-xl hover:bg-pink-700 transition shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px] flex items-center justify-center gap-2">
                            KONFIRMASI PESANAN
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>

                    {{-- Trust Badges --}}
                    <div class="mt-6 flex items-center justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase">Secure Payment</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase">Original Brand</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase">Safe Packing</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor rekening berhasil disalin!');
    });
}
</script>
@endpush
@endsection