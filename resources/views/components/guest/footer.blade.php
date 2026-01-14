{{-- Brutalist Guest Footer --}}
<footer class="brutal-border-t bg-asphalt text-white mt-24">
    <div class="brutal-container">
        {{-- Main Footer Content --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 py-12 brutal-border-b border-white/20">
            {{-- Brand Column --}}
            <div class="md:col-span-2">
                <h3 class="font-display text-3xl font-bold tracking-tight mb-4">DISTROZONE</h3>
                <p class="font-mono text-sm text-gray-300 mb-6 max-w-md">
                    RAW STREETWEAR FOR THE UNDERGROUND.<br/>
                    NO HYPE. NO BULLSHIT. JUST GEAR.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="brutal-border brutal-border-thick border-white w-10 h-10 flex items-center justify-center hover:bg-white hover:text-asphalt transition-colors">
                        <span class="sr-only">Instagram</span>
                        <span class="font-bold">IG</span>
                    </a>
                    <a href="#" class="brutal-border brutal-border-thick border-white w-10 h-10 flex items-center justify-center hover:bg-white hover:text-asphalt transition-colors">
                        <span class="sr-only">Twitter</span>
                        <span class="font-bold">X</span>
                    </a>
                    <a href="#" class="brutal-border brutal-border-thick border-white w-10 h-10 flex items-center justify-center hover:bg-white hover:text-asphalt transition-colors">
                        <span class="sr-only">TikTok</span>
                        <span class="font-bold">TT</span>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-display text-sm font-bold uppercase tracking-wide mb-4">NAVIGATE</h4>
                <nav class="flex flex-col gap-2 font-mono text-sm">
                    <a href="{{ route('guest.home') }}" class="hover:text-accent transition-colors uppercase">Home</a>
                    <a href="{{ route('guest.catalog') }}" class="hover:text-accent transition-colors uppercase">Catalog</a>
                    <a href="{{ route('guest.about') }}" class="hover:text-accent transition-colors uppercase">About</a>
                </nav>
            </div>

            {{-- Contact Info --}}
            <div>
                <h4 class="font-display text-sm font-bold uppercase tracking-wide mb-4">LOCATION</h4>
                <address class="font-mono text-sm text-gray-300 not-italic leading-relaxed">
                    Jln. Raya Pegangsaan Timur<br/>
                    No.29H, Kelapa Gading<br/>
                    Jakarta, Indonesia
                </address>
                <div class="mt-4 font-mono text-sm">
                    <p class="text-gray-300">OFFLINE HOURS:</p>
                    <p class="text-white">10:00 - 20:00</p>
                    <p class="text-accent">CLOSED MONDAY</p>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 font-mono text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} DISTROZONE. ALL RIGHTS RESERVED.</p>
                <div class="flex gap-6 uppercase">
                    <a href="#" class="hover:text-accent transition-colors">PRIVACY</a>
                    <a href="#" class="hover:text-accent transition-colors">TERMS</a>
                    <a href="#" class="hover:text-accent transition-colors">SHIPPING</a>
                </div>
            </div>
        </div>
    </div>
</footer>
