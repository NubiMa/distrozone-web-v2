{{-- resources/views/components/guest/footer.blade.php --}}
<footer class="bg-white border-t-4 border-black mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-pink-600 rounded-full border-3 border-black flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">DistroZone</span>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Fashion retro-futuristik untuk generasi masa depan. Bergaya tanpa batas, harga pas.
                </p>
            </div>

            {{-- Belanja --}}
            <div>
                <h3 class="text-sm font-bold mb-4 uppercase">Belanja</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('catalog') }}" class="text-sm text-gray-600 hover:text-pink-600">Semua Produk</a></li>
                    <li><a href="{{ route('catalog', ['filter' => 'new']) }}" class="text-sm text-gray-600 hover:text-pink-600">New Arrivals</a></li>
                    <li><a href="{{ route('catalog', ['filter' => 'best']) }}" class="text-sm text-gray-600 hover:text-pink-600">Best Sellers</a></li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div>
                <h3 class="text-sm font-bold mb-4 uppercase">Bantuan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-600 hover:text-pink-600">FAQ</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-pink-600">Pengiriman</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-pink-600">Retur & Refund</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-12 pt-8 border-t-2 border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">© 2024 DISTROZONE. ALL RIGHTS RESERVED.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="w-10 h-10 border-3 border-black rounded-full flex items-center justify-center hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <span class="text-sm font-bold">IG</span>
                </a>
                <a href="#" class="w-10 h-10 border-3 border-black rounded-full flex items-center justify-center hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <span class="text-sm font-bold">TW</span>
                </a>
                <a href="#" class="w-10 h-10 border-3 border-black rounded-full flex items-center justify-center hover:bg-gray-50 transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <span class="text-sm font-bold">YT</span>
                </a>
            </div>
        </div>
    </div>
</footer>