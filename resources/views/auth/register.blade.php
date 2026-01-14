<x-layouts.guest>
    <x-slot:title>Daftar - DistroZone</x-slot:title>

    <div class="min-h-screen bg-bg-secondary flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="font-display font-bold text-4xl mb-2">DISTROZONE</h1>
                <p class="text-gray-600">Buat akun baru</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-lg shadow-card p-8">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus
                            class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-fast"
                            placeholder="Nama lengkap kamu">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-fast"
                            placeholder="email@example.com">
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-fast"
                            placeholder="08123456789">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold mb-2">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-fast"
                            placeholder="Minimal 8 karakter">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-semibold mb-2">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-fast"
                            placeholder="Ketik ulang password">
                    </div>

                    <!-- Terms -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" required class="mr-2 mt-1 rounded">
                            <span class="text-sm text-gray-600">
                                Saya setuju dengan
                                <a href="#" class="text-accent hover:underline">Syarat & Ketentuan</a>
                                dan
                                <a href="#" class="text-accent hover:underline">Kebijakan Privasi</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-primary hover:bg-accent text-white font-bold py-4 rounded-lg transition-fast">
                        Daftar
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-border"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-accent hover:underline font-semibold">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('guest.home') }}" class="text-gray-600 hover:text-accent text-sm transition-fast">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
