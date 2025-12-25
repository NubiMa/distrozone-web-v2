{{-- resources/views/layouts/customer.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DistroZone - Fashion Retro Futuristik')</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Dot Pattern Background */
        body {
            background-color: #f5f5f5;
            background-image: radial-gradient(circle, #d1d1d1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
    
    @stack('styles')
</head>
<body class="min-h-screen">
    {{-- Customer Navbar --}}
    <x-customer.navbar />

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-[1400px] mx-auto px-6 mb-4">
        <div class="bg-green-100 border-3 border-green-600 rounded-xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-[1400px] mx-auto px-6 mb-4">
        <div class="bg-pink-100 border-3 border-pink-600 rounded-xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-bold text-pink-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <main class="max-w-[1400px] mx-auto">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-guest.footer />

    @stack('scripts')
</body>
</html>