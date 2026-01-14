<x-layouts.customer>
    <x-slot:title>Alamat Saya - DistroZone</x-slot:title>

    <div class="bg-bg-secondary min-h-screen py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="font-display font-bold text-3xl">Alamat Saya</h1>
                <button onclick="showAddModal()"
                    class="bg-primary hover:bg-accent text-white font-semibold px-6 py-3 rounded-lg transition-fast">
                    + Tambah Alamat
                </button>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Addresses Grid -->
            @if ($addresses->count() > 0)
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach ($addresses as $address)
                        <div class="bg-white rounded-lg shadow-card p-6 relative">
                            @if ($address->is_default)
                                <div class="absolute top-4 right-4">
                                    <span class="bg-accent text-white text-xs font-bold px-3 py-1 rounded-full">
                                        Utama
                                    </span>
                                </div>
                            @endif

                            <h3 class="font-semibold text-lg mb-2">{{ $address->label }}</h3>
                            <p class="text-text-secondary text-sm mb-1">{{ $address->recipient_name }}</p>
                            <p class="text-text-secondary text-sm mb-1">{{ $address->phone }}</p>
                            <p class="text-gray-800 mt-3">
                                {{ $address->address }}<br>
                                {{ $address->city }}, {{ $address->province }}<br>
                                {{ $address->postal_code }}
                            </p>

                            <div class="flex gap-3 mt-6">
                                @if (!$address->is_default)
                                    <form method="POST"
                                        action="{{ route('customer.addresses.set-default', $address->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="text-sm text-accent hover:text-primary font-semibold transition-fast">
                                            Jadikan Utama
                                        </button>
                                    </form>
                                @endif
                                <button onclick="editAddress({{ $address->id }})"
                                    class="text-sm text-gray-600 hover:text-primary font-semibold transition-fast">
                                    Edit
                                </button>
                                @if (!$address->is_default)
                                    <form method="POST"
                                        action="{{ route('customer.addresses.destroy', $address->id) }}"
                                        onsubmit="return confirm('Hapus alamat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm text-red-500 hover:text-red-700 font-semibold transition-fast">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg p-12 text-center shadow-card max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h2 class="font-display font-bold text-2xl mb-2">Belum Ada Alamat</h2>
                    <p class="text-text-secondary mb-6">Tambahkan alamat pengiriman kamu</p>
                    <button onclick="showAddModal()"
                        class="inline-block bg-primary hover:bg-accent text-white font-semibold px-8 py-3 rounded-lg transition-fast">
                        Tambah Alamat
                    </button>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function showAddModal() {
                alert('Address form modal akan ditambahkan (requires Alpine.js modal component)');
            }

            function editAddress(id) {
                alert('Edit address modal untuk ID: ' + id);
            }
        </script>
    @endpush
</x-layouts.customer>
