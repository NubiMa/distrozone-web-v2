<x-layouts.customer>
    <x-slot:title>Orders - DistroZone</x-slot:title>

    <div class="bg-bg-secondary min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <h1 class="font-display font-bold text-3xl mb-8">Pesanan Saya</h1>

            <!-- Order Status Filter -->
            <div class="bg-white rounded-lg p-4 mb-6 shadow-card">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customer.orders') }}"
                        class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-primary text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Semua
                    </a>
                    <a href="{{ route('customer.orders', ['status' => 'pending_payment']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') === 'pending_payment' ? 'bg-accent text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Menunggu Pembayaran
                    </a>
                    <a href="{{ route('customer.orders', ['status' => 'pending_verification']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') === 'pending_verification' ? 'bg-yellow-500 text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Verifikasi
                    </a>
                    <a href="{{ route('customer.orders', ['status' => 'processing']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') === 'processing' ? 'bg-blue-500 text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Diproses
                    </a>
                    <a href="{{ route('customer.orders', ['status' => 'completed']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') === 'completed' ? 'bg-green-500 text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Selesai
                    </a>
                    <a href="{{ route('customer.orders', ['status' => 'cancelled']) }}"
                        class="px-4 py-2 roun ded-lg {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-bg-secondary text-gray-600 hover:bg-gray-200' }} transition-fast">
                        Dibatalkan
                    </a>
                </div>
            </div>

            <!-- Orders List -->
            @if ($orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow-card overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-bg-secondary px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <span class="font-semibold">{{ $order->order_number }}</span>
                                    <span
                                        class="text-text-secondary text-sm">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    @php
                                        $statusColors = [
                                            'pending_payment' => 'bg-accent text-white',
                                            'pending_verification' => 'bg-yellow-500 text-white',
                                            'processing' => 'bg-blue-500 text-white',
                                            'completed' => 'bg-green-500 text-white',
                                            'cancelled' => 'bg-red-500 text-white',
                                        ];
                                        $statusLabels = [
                                            'pending_payment' => 'Menunggu Pembayaran',
                                            'pending_verification' => 'Verifikasi Pembayaran',
                                            'processing' => 'Diproses',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-500 text-white' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="px-6 py-4">
                                @foreach ($order->items->take(3) as $item)
                                    <div class="flex gap-4 mb-3 last:mb-0">
                                        <div class="w-16 h-16 flex-shrink-0 bg-bg-secondary rounded">
                                            @if ($item->productVariant?->product?->primaryImage)
                                                <img src="{{ Storage::url($item->productVariant->product->primaryImage->image_path) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-full h-full object-cover rounded">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-sm">{{ $item->product_name }}</h4>
                                            <p class="text-text-secondary text-xs">{{ $item->variant_details }} x
                                                {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold">Rp
                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($order->items->count() > 3)
                                    <p class="text-text-secondary text-sm mt-2">+{{ $order->items->count() - 3 }}
                                        produk lainnya</p>
                                @endif
                            </div>

                            <!-- Order Footer -->
                            <div class="bg-bg-secondary px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-text-secondary text-sm">Total Pembayaran</p>
                                    <p class="font-bold text-xl text-accent">Rp
                                        {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('customer.orders.show', $order->id) }}"
                                        class="px-6 py-2 border-2 border-primary hover:bg-primary hover:text-white text-primary font-semibold rounded-lg transition-fast">
                                        Lihat Detail
                                    </a>
                                    @if ($order->status === 'pending_payment')
                                        <a href="{{ route('customer.payment.upload', $order->id) }}"
                                            class="px-6 py-2 bg-accent hover:bg-primary text-white font-semibold rounded-lg transition-fast">
                                            Upload Bukti Bayar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg p-12 text-center shadow-card max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="font-display font-bold text-2xl mb-2">Belum Ada Pesanan</h2>
                    <p class="text-text-secondary mb-6">Kamu belum memiliki pesanan</p>
                    <a href="{{ route('customer.catalog') }}"
                        class="inline-block bg-primary hover:bg-accent text-white font-semibold px-8 py-3 rounded-lg transition-fast">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.customer>
