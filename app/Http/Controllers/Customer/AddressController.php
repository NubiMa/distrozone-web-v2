<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Tampilkan daftar alamat
     */
    public function index(Request $request)
    {
        $addresses = CustomerAddress::where('user_id', $request->user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar destinasi pengiriman yang tersedia
        $destinations = $this->shippingService->getAvailableDestinations();

        return view('customer.addresses', compact('addresses', 'destinations'));
    }

    /**
     * Simpan alamat baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean',
        ], [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
        ]);

        // Validasi apakah provinsi termasuk area pengiriman
        if (!$this->shippingService->isShippingAvailable($validated['province'])) {
            return back()
                ->withInput()
                ->withErrors(['province' => 'Maaf, pengiriman hanya tersedia untuk wilayah Pulau Jawa.']);
        }

        // Jika set sebagai default, hapus default lainnya
        if ($validated['is_default'] ?? false) {
            CustomerAddress::where('user_id', $request->user()->id)
                ->update(['is_default' => false]);
        }

        CustomerAddress::create([
            'user_id' => $request->user()->id,
            'label' => $validated['label'] ?? null,
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'province' => $validated['province'],
            'postal_code' => $validated['postal_code'] ?? null,
            'is_default' => $validated['is_default'] ?? false,
        ]);

        return redirect()->route('customer.addresses')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Update alamat
     */
    public function update(Request $request, int $id)
    {
        $address = CustomerAddress::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean',
        ], [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
        ]);

        // Validasi apakah provinsi termasuk area pengiriman
        if (!$this->shippingService->isShippingAvailable($validated['province'])) {
            return back()
                ->withInput()
                ->withErrors(['province' => 'Maaf, pengiriman hanya tersedia untuk wilayah Pulau Jawa.']);
        }

        // Jika set sebagai default, hapus default lainnya
        if (isset($validated['is_default']) && $validated['is_default']) {
            CustomerAddress::where('user_id', $request->user()->id)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.addresses')
            ->with('success', 'Alamat berhasil diperbarui.');
    }

    /**
     * Hapus alamat
     */
    public function delete(Request $request, int $id)
    {
        $address = CustomerAddress::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $address->delete();

        return redirect()->route('customer.addresses')
            ->with('success', 'Alamat berhasil dihapus.');
    }

    /**
     * Set alamat sebagai default
     */
    public function setDefault(Request $request, int $id)
    {
        $address = CustomerAddress::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        // Hapus semua default
        CustomerAddress::where('user_id', $request->user()->id)
            ->update(['is_default' => false]);

        // Set ini sebagai default
        $address->update(['is_default' => true]);

        return redirect()->route('customer.addresses')
            ->with('success', 'Alamat utama berhasil diubah.');
    }
}
