<x-layouts.customer>
    <x-slot:title>Profil Saya - DistroZone</x-slot:title>

    <div class="bg-bg-secondary min-h-screen py-8">
        <div class="container mx-auto px-4 max-w-2xl">
            <!-- Page Header -->
            <h1 class="font-display font-bold text-3xl mb-8">Profil Saya</h1>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <div class="bg-white rounded-lg shadow-card p-6 mb-6">
                <h2 class="font-display font-bold text-xl mb-6">Informasi Pribadi</h2>

                <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full bg-primary hover:bg-accent text-white font-bold py-3 rounded-lg transition-fast">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-card p-6">
                <h2 class="font-display font-bold text-xl mb-6">Ubah Password</h2>

                <form method="POST" action="{{ route('customer.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Password Baru</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full bg-accent hover:bg-primary text-white font-bold py-3 rounded-lg transition-fast">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.customer>
