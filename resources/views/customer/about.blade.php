{{-- Brutalist About Page (Customer - same content as guest) --}}
@extends('layouts.customer')

@section('title', 'ABOUT - DISTROZONE')

@section('content')
<div class="brutal-container py-8">
    
    {{-- Hero Statement --}}
    <section class="brutal-hero flex items-center justify-center text-center mb-16">
        <div class="max-w-4xl">
            <h1 class="font-display text-brutal-6xl font-bold uppercase tracking-tight mb-6">
                RAW STREETWEAR<br/>FROM JAKARTA
            </h1>
            <p class="font-mono text-xl">
                NO HYPE. NO BULLSHIT. JUST AUTHENTIC DISTRO GEAR.
            </p>
        </div>
    </section>

    {{-- Story Section --}}
    <section class="max-w-4xl mx-auto mb-16">
        <div class="brutal-block bg-white p-12">
            <h2 class="font-display text-brutal-3xl font-bold uppercase tracking-tight mb-6 brutal-border-b pb-4">
                OUR STORY
            </h2>
            <div class="font-mono text-lg leading-relaxed space-y-6">
                <p>
                    DISTROZONE WAS BORN FROM THE UNDERGROUND STREETWEAR SCENE OF JAKARTA. 
                    WE STARTED AS A SMALL COLLECTIVE SELLING LOCALLY-MADE TEES AT PUNK SHOWS AND SKATE PARKS.
                </p>
                <p>
                    WE DON'T FOLLOW TRENDS. WE DON'T DO HYPE DROPS. EVERY PIECE IN OUR CATALOG 
                    IS SELECTED BECAUSE IT'S AUTHENTIC, WELL-MADE, AND REPRESENTS THE REAL SPIRIT OF INDONESIAN STREET CULTURE.
                </p>
                <p>
                    OUR SHOP AT KELAPA GADING HAS BECOME A MEETING POINT FOR CREATIVES, SKATERS, 
                    MUSICIANS, AND ANYONE WHO VALUES HONEST DESIGN OVER CORPORATE BRANDING.
                </p>
            </div>
        </div>
    </section>

    {{-- Values Grid --}}
    <section class="mb-16">
        <h2 class="font-display text-brutal-3xl font-bold uppercase tracking-tight mb-8 brutal-border-b pb-4">
            WHAT WE STAND FOR
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="brutal-block bg-white p-8">
                <h3 class="font-display text-brutal-xl font-bold uppercase tracking-tight mb-4">
                    AUTHENTICITY
                </h3>
                <p class="font-mono text-sm">
                    Every brand we carry is vetted. No bootlegs, no counterfeits. 
                    Only real distro labels and independent creators.
                </p>
            </div>

            <div class="brutal-block bg-white p-8">
                <h3 class="font-display text-brutal-xl font-bold uppercase tracking-tight mb-4">
                    QUALITY
                </h3>
                <p class="font-mono text-sm">
                    We don't sell garbage. Every tee is screen-printed on premium cotton. 
                    Built to last, not to fall apart after three washes.
                </p>
            </div>

            <div class="brutal-block bg-white p-8">
                <h3 class="font-display text-brutal-xl font-bold uppercase tracking-tight mb-4">
                    COMMUNITY
                </h3>
                <p class="font-mono text-sm">
                    We support local artists, bands, and creators. 
                    A portion of every sale goes back to the scene.
                </p>
            </div>
        </div>
    </section>

    {{-- Location Info --}}
    <section class="brutal-block bg-asphalt text-white p-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="font-display text-brutal-3xl font-bold uppercase tracking-tight mb-6">
                    VISIT US
                </h2>
                <div class="font-mono text-sm space-y-4">
                    <div>
                        <p class="text-gray-400 uppercase mb-2">LOCATION</p>
                        <p>Jln. Raya Pegangsaan Timur No.29H<br/>Kelapa Gading, Jakarta</p>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase mb-2">HOURS (OFFLINE)</p>
                        <p>10:00 - 20:00 (Tue-Sun)</p>
                        <p class="text-accent">CLOSED MONDAY</p>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase mb-2">ONLINE ORDERS</p>
                        <p>10:00 - 17:00 (Every Day)</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="font-display text-brutal-3xl font-bold uppercase tracking-tight mb-6">
                    CONTACT
                </h2>
                <div class="font-mono text-sm space-y-4">
                    <div>
                        <p class="text-gray-400 uppercase mb-2">EMAIL</p>
                        <a href="mailto:info@distrozone.id" class="hover:text-accent transition-colors">
                            INFO@DISTROZONE.ID
                        </a>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase mb-2">PHONE</p>
                        <a href="tel:+622112345678" class="hover:text-accent transition-colors">
                            +62 21 1234 5678
                        </a>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase mb-2">SOCIALS</p>
                        <div class="flex gap-4">
                            <a href="#" class="hover:text-accent transition-colors">INSTAGRAM</a>
                            <a href="#" class="hover:text-accent transition-colors">TWITTER</a>
                            <a href="#" class="hover:text-accent transition-colors">TIKTOK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection