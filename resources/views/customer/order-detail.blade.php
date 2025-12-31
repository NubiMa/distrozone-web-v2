@extends('layouts.customer')

@section('title', 'DistroZone - Style Masa Depan, Harga Teman')

@section('content')

<!-- Navbar Placeholder -->

<div class="min-h-screen bg-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm mb-6">
            <a href="/" class="hover:underline">Beranda</a>
            <span>></span>
            <a href="{{ route('customer.orders') }}" class="hover:underline">Akun</a>
            <span>></span>
            <span class="bg-pink-500 text-white px-3 py-1 font-bold text-xs">Detail Pesanan</span>
        </div>

        <h1 class="text-4xl font-black mb-2">DETAIL PESANAN</h1>
        <p class="text-gray-600 mb-6">Kelola dan pantau status belanjaanmu di sini.</p>

        <button class="bg-yellow-400 text-black px-6 py-2 font-bold border-2 border-black mb-8 hover:bg-yellow-500 transition flex items-center gap-2">
            ⏰ MENUNGGU PEMBAYARAN
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Order Info -->
                <div class="bg-cyan-100 border-4 border-black p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ORDER ID</p>
                            <p class="font-black text-lg">#DZ-2024-001</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">TANGGAL PEMESANAN</p>
                            <p class="font-bold">📅 24 Oktober 2023</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">ESTIMASI TIBA</p>
                            <p class="font-bold">📦 26-28 Okt 2023</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="bg-white border-4 border-black p-6">
                    <h2 class="font-black text-xl mb-4 flex items-center gap-2">
                        🛍️ DETAIL PRODUK
                    </h2>

                    <div class="space-y-4">
                        <div class="flex gap-4 p-4 border-2 border-gray-200">
                            <img src="/api/placeholder/100/100" alt="Product" class="w-20 h-20 border-2 border-black">
                            <div class="flex-1">
                                <p class="font-bold">Skull Tee - Graphic Print</p>
                                <div class="flex gap-4 mt-1">
                                    <span class="bg-gray-200 px-2 py-1 text-xs font-bold">Size: L</span>
                                    <span class="bg-gray-200 px-2 py-1 text-xs font-bold">Qty: 1</span>
                                </div>
                                <p class="text-right font-bold text-lg mt-2">Rp 150.000</p>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 border-2 border-gray-200">
                            <img src="/api/placeholder/100/100" alt="Product" class="w-20 h-20 border-2 border-black">
                            <div class="flex-1">
                                <p class="font-bold">Oversized Basic White</p>
                                <div class="flex gap-4 mt-1">
                                    <span class="bg-gray-200 px-2 py-1 text-xs font-bold">Size: XL</span>
                                    <span class="bg-gray-200 px-2 py-1 text-xs font-bold">Qty: 2</span>
                                </div>
                                <p class="text-right font-bold text-lg mt-2">Rp 250.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Pengiriman -->
                <div class="bg-white border-4 border-black p-6">
                    <h2 class="font-black text-xl mb-4 flex items-center gap-2">
                        📍 ALAMAT PENGIRIMAN
                    </h2>

                    <div class="border-2 border-dashed border-gray-300 p-4">
                        <p class="font-bold mb-2">Budi Santoso (Rumah)</p>
                        <p class="text-gray-700">Jl. Distro Raya No. 88, Kemang Utara,</p>
                        <p class="text-gray-700">Jakarta Selatan, DKI Jakarta 12730</p>
                        <p class="mt-2 text-sm">📞 0812-3456-7890</p>
                    </div>
                </div>

            </div>

            <!-- Right Section - Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border-4 border-black p-6 sticky top-4">
                    <h2 class="font-black text-xl mb-4 flex items-center gap-2">
                        💰 RINCIAN PEMBAYARAN
                    </h2>

                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal Produk</span>
                            <span>Rp 400.000</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp 20.000</span>
                        </div>

                        <div class="flex justify-between text-green-600">
                            <span>Diskon Voucher</span>
                            <span>-Rp 10.000</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Biaya Layanan</span>
                            <span>Rp 1.000</span>
                        </div>
                    </div>

                    <div class="border-t-2 border-black pt-4 mb-6">
                        <div class="flex justify-between text-xl font-black">
                            <span>Total Belanja</span>
                            <span class="text-pink-500">Rp 411.000</span>
                        </div>
                    </div>

                    <div class="bg-gray-100 border-2 border-gray-300 p-4 mb-4">
                        <p class="text-sm font-bold mb-2">METODE PEMBAYARAN</p>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🏦</span>
                            <span class="font-bold">Bank Transfer (BCA)</span>
                        </div>
                    </div>

                    <a href="{{ route('customer.order.upload', 'DZ-2024-001') }}" class="block w-full bg-pink-500 text-white text-center py-4 font-black border-4 border-black hover:bg-pink-600 transition mb-3">
                        🔐 UNGGAH BUKTI TRANSFER
                    </a>

                    <button class="block w-full bg-white text-black text-center py-3 font-bold border-2 border-black hover:bg-gray-100 transition">
                        HUBUNGI BANTUAN
                    </button>

                    <!-- Garansi Info -->
                    <div class="bg-black text-cyan-400 p-4 mt-6 border-2 border-cyan-400">
                        <div class="flex items-start gap-2 mb-2">
                            <span class="text-2xl">✅</span>
                            <div>
                                <p class="font-bold">Garansi DistroZone</p>
                                <p class="text-sm text-white">Barang tidak sesuai? Ajukan retur dalam 3x24 jam setelah barang diterima.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
