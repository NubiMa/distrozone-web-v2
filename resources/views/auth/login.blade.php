{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login - DistroZone')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 py-12">
    
    <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-0">
        
        {{-- Left Side - Promotional Banner --}}
        <div class="relative bg-gradient-to-br from-gray-800 to-gray-900 border-4 border-black rounded-l-3xl lg:rounded-r-none rounded-3xl lg:rounded-3xl overflow-hidden p-12 flex flex-col justify-center shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] lg:shadow-none">
            <span class="inline-block px-4 py-1 bg-pink-600 text-white text-xs font-bold border-2 border-white rounded-full mb-6 w-fit shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                NEW DROPS
            </span>
            
            <h2 class="text-5xl font-black text-white mb-4">
                URBAN<br>
                CULTURE
            </h2>
            
            <p class="text-white/80 leading-relaxed mb-8">
                Koleksi terbaru kaos distro dengan desain anti-mainstream. Style Y2K yang autentik.
            </p>
            
            {{-- Decorative Element --}}
            <div class="absolute top-8 right-8 w-16 h-16">
                <svg viewBox="0 0 100 100" class="text-white/20">
                    <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="3" fill="none"/>
                </svg>
            </div>

            {{-- Model Image (Optional) --}}
            <div class="absolute bottom-0 right-0 opacity-20">
                <img src="{{ asset('images/urban-model.png') }}" alt="Urban Model" class="w-64">
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="bg-white border-4 border-black border-l-0 rounded-r-3xl lg:rounded-l-none rounded-3xl lg:rounded-3xl p-12 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
            <div class="mb-8">
                <span class="inline-block px-3 py-1 bg-blue-400 text-white text-xs font-bold border-2 border-black rounded-full mb-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    SECURE ACCESS
                </span>
                <h1 class="text-4xl font-black mb-2">
                    <span class="flex items-center gap-2">
                        🙌 WELCOME BACK!
                    </span>
                </h1>
                <p class="text-gray-600">Masuk untuk mulai belanja barang distro terkeren.</p>
            </div>

            {{-- Error Alert --}}
            @if($errors->any())
            <div class="bg-pink-100 border-3 border-pink-600 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-pink-800 mb-1">Login Gagal</h3>
                        <p class="text-sm text-pink-700">{{ $errors->first() }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Login Form --}}
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email --}}
                <x-input 
                    type="email"
                    name="email"
                    label="Email"
                    placeholder="guest@example.com"
                    :required="true"
                    value="{{ old('email') }}"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </x-slot>
                </x-input>

                {{-- Password --}}
                <div>
                    <x-input 
                        type="password"
                        name="password"
                        label="Kata Sandi"
                        placeholder="••••••••"
                        :required="true"
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </x-slot>
                    </x-input>
                    
                    <div class="flex items-center justify-end mt-2">
                        <a href="#" class="text-sm font-bold text-pink-600 hover:underline">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                </div>

                {{-- Submit Button --}}
                <x-button type="submit" variant="primary" size="lg" :fullWidth="true">
                    LOGIN SEKARANG
                </x-button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 border-t-2 border-gray-200"></div>
                <span class="flex items-center gap-2 w-12 h-12 bg-gray-100 border-3 border-black rounded-full justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </span>
                <div class="flex-1 border-t-2 border-gray-200"></div>
            </div>

            {{-- Register Link --}}
            <div class="text-center">
                <p class="text-gray-600 mb-3">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-pink-600 hover:underline">
                        Daftar di sini →
                    </a>
                </p>
            </div>
        </div>

    </div>

</div>
@endsection