{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Daftar Akun - DistroZone')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 py-12">
    
    <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-0">
        
        {{-- Left Side - Promotional Banner --}}
        <div class="relative bg-gradient-to-br from-blue-400 to-cyan-500 border-4 border-black rounded-l-3xl lg:rounded-r-none rounded-3xl lg:rounded-3xl overflow-hidden p-12 flex flex-col justify-center shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] lg:shadow-none">
            <span class="inline-block px-4 py-1 bg-white text-black text-xs font-bold border-2 border-black rounded-full mb-6 w-fit shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                • NEW DROPS
            </span>
            
            <h2 class="text-5xl font-black text-white mb-4">
                JOIN THE<br>
                <span class="text-pink-600">ZONE</span>
            </h2>
            
            <p class="text-white mb-8 leading-relaxed">
                Daftar sekarang untuk dapetin akses eksklusif ke koleksi limited edition DistroZone sebelum kehabisan.
            </p>

            {{-- Member Badge --}}
            <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-sm border-2 border-white rounded-2xl p-4 w-fit">
                <div class="flex -space-x-2">
                    <div class="w-10 h-10 bg-pink-600 border-2 border-white rounded-full"></div>
                    <div class="w-10 h-10 bg-blue-600 border-2 border-white rounded-full"></div>
                    <div class="w-10 h-10 bg-purple-600 border-2 border-white rounded-full"></div>
                </div>
                <span class="text-white font-bold">+2k Members</span>
            </div>

            {{-- Decorative Lock Icon --}}
            <div class="absolute bottom-12 right-12 w-32 h-32 opacity-20">
                <svg viewBox="0 0 100 100" class="text-white">
                    <circle cx="50" cy="60" r="30" fill="currentColor"/>
                    <rect x="35" y="40" width="30" height="35" rx="5" fill="currentColor"/>
                    <path d="M 35 50 Q 35 30, 50 30 T 65 50" stroke="currentColor" stroke-width="6" fill="none"/>
                </svg>
            </div>
        </div>

        {{-- Right Side - Register Form --}}
        <div class="bg-white border-4 border-black border-l-0 rounded-r-3xl lg:rounded-l-none rounded-3xl lg:rounded-3xl p-12 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
            <div class="mb-8">
                <h1 class="text-4xl font-black mb-2">BUAT AKUN GUEST</h1>
                <p class="text-gray-600">Isi data diri lo buat mulai belanja.</p>
            </div>

            {{-- Error Alert --}}
            @if($errors->any())
            <div class="bg-pink-100 border-3 border-pink-600 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-pink-800 mb-1">Ada Kesalahan</h3>
                        <ul class="text-sm text-pink-700 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- Register Form --}}
            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Name --}}
                <x-input 
                    type="text"
                    name="name"
                    label="Nama Lengkap"
                    placeholder="Siapa nama lo?"
                    :required="true"
                    value="{{ old('name') }}"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </x-slot>
                </x-input>

                {{-- Email --}}
                <x-input 
                    type="email"
                    name="email"
                    label="Email Address"
                    placeholder="email@kamu.com"
                    :required="true"
                    value="{{ old('email') }}"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </x-slot>
                </x-input>

                {{-- Password Row --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Password --}}
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

                    {{-- Confirm Password --}}
                    <x-input 
                        type="password"
                        name="password_confirmation"
                        label="Konfirmasi"
                        placeholder="••••••••"
                        :required="true"
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </x-slot>
                    </x-input>
                </div>

                {{-- Terms & Conditions --}}
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input 
                        type="checkbox" 
                        name="terms" 
                        required
                        class="w-5 h-5 mt-1 border-3 border-black rounded text-pink-600 focus:ring-pink-600 cursor-pointer"
                    >
                    <span class="text-sm text-gray-700 leading-relaxed">
                        Gue setuju sama 
                        <a href="#" class="font-bold text-pink-600 hover:underline">Syarat & Ketentuan</a> 
                        DistroZone.
                    </span>
                </label>

                {{-- Submit Button --}}
                <x-button type="submit" variant="primary" size="lg" :fullWidth="true">
                    DAFTAR SEKARANG →
                </x-button>
            </form>

            {{-- Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Udah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-pink-600 hover:underline">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>

    </div>

</div>
@endsection