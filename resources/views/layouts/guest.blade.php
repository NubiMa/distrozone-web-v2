{{-- resources/views/layouts/guest.blade.php --}}
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
    {{-- Navbar --}}
    <x-guest.navbar />

    {{-- Main Content --}}
    <main class="max-w-[1400px] mx-auto">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-guest.footer />

    @stack('scripts')
</body>
</html>