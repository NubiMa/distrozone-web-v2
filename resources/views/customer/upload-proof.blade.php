@extends('layouts.customer')

@section('title', 'DistroZone - Style Masa Depan, Harga Teman')

@section('content')


<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <div class="bg-yellow-400 border-4 border-black p-6 mb-8">
            <p class="text-sm font-bold mb-1">⏰ MENUNGGU PEMBAYARAN</p>
            <h1 class="text-4xl font-black italic mb-2">UNGGAH BUKTI TRANSFER</h1>
            <p>Selesaikan pesananmu agar barang distro favoritmu segera dikirim!</p>
        </div>

        <form action="{{ route('customer.order.proof.store', 'DZ-2023-001') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Left Section -->
                <div class="space-y-6">

                    <!-- Instruksi Transfer -->
                    <div class="bg-white border-4 border-black p-6">
                        <h2 class="text-xl font-black mb-4 flex items-center gap-2">
                            🏦 Instruksi Transfer
                        </h2>

                        <div class="space-y-4">
                            <div class="bg-blue-50 border-2 border-blue-300 p-4">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="bg-blue-600 text-white px-4 py-2 font-bold text-lg">BCA</span>
                                    <p class="text-sm text-gray-600">a/n DistroZone Indonesia</p>
                                </div>

                                <div class="bg-white border-2 border-black p-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-600">No. Rekening</p>
                                        <p class="text-2xl font-black">123-456-789</p>
                                    </div>
                                    <button type="button" onclick="copyText('123-456-789')" class="bg-black text-white px-4 py-2 font-bold hover:bg-pink-500 transition">
                                        📋 Salin
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mt-4">
                            <p class="font-bold text-sm mb-1">⚠️ PENTING</p>
                            <p class="text-sm">Pastikan nominal transfer sesuai hingga 3 digit terakhir untuk mempercepat verifikasi otomatis.</p>
                        </div>
                    </div>

                    <!-- Data Pengirim -->
                    <div class="bg-white border-4 border-black p-6">
                        <h2 class="text-xl font-black mb-4 flex items-center gap-2">
                            1️⃣ Data Pengirim
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">Nama Pemilik Rekening</label>
                                <input type="text" name="account_name" placeholder="Contoh: Budi Santoso" required class="w-full border-2 border-black px-4 py-3 focus:outline-none focus:border-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-2">Bank Asal</label>
                                <select name="bank_origin" required class="w-full border-2 border-black px-4 py-3 focus:outline-none focus:border-pink-500">
                                    <option value="">Pilih bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="CIMB">CIMB Niaga</option>
                                    <option value="Permata">Permata</option>
                                    <option value="Other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Section -->
                <div class="space-y-6">

                    <!-- Upload Bukti -->
                    <div class="bg-white border-4 border-black p-6">
                        <h2 class="text-xl font-black mb-4 flex items-center gap-2">
                            2️⃣ Upload Bukti
                        </h2>

                        <div class="border-4 border-dashed border-gray-400 p-8 text-center hover:border-pink-500 transition cursor-pointer" id="uploadArea">
                            <input type="file" name="proof_image" id="proofImage" accept="image/*,.pdf" required class="hidden" onchange="previewImage(event)">

                            <label for="proofImage" class="cursor-pointer">
                                <div id="uploadPlaceholder">
                                    <span class="text-6xl mb-4 block">☁️</span>
                                    <p class="font-bold text-lg mb-2">Klik untuk upload atau drag & drop</p>
                                    <p class="text-sm text-gray-600">JPG, PNG atau PDF (Max. 2MB)</p>
                                </div>

                                <div id="imagePreview" class="hidden">
                                    <img id="previewImg" src="" alt="Preview" class="max-w-full h-auto border-2 border-black mb-2">
                                    <p class="text-sm text-green-600 font-bold">✅ File berhasil dipilih</p>
                                </div>
                            </label>
                        </div>

                        <div class="flex items-start gap-2 mt-4 text-sm bg-gray-100 p-3 border-2 border-gray-300">
                            <span class="text-lg">💡</span>
                            <p><strong>Tips:</strong> Pastikan foto bukti transfer terlihat jelas dan tidak blur. Hindari menggunakan screenshot yang sudah di-crop berlebihan.</p>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-cyan-100 border-4 border-black p-6">
                        <h3 class="font-black mb-3">TOTAL PEMBAYARAN</h3>
                        <p class="text-5xl font-black text-pink-500 mb-2">Rp 150.000</p>

                        <div class="bg-white border-2 border-black p-3 mt-4">
                            <p class="text-xs text-gray-600 mb-1">ID PESANAN</p>
                            <p class="font-black text-lg">#DZ-2023-001</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-pink-500 text-white py-5 font-black text-lg border-4 border-black hover:bg-pink-600 transition">
                        ➡️ Kirim Bukti
                    </button>

                </div>

            </div>
        </form>

        <!-- Help Section -->
        <div class="bg-black text-white p-6 mt-8 border-4 border-black">
            <div class="flex items-center gap-4">
                <span class="text-5xl">💬</span>
                <div class="flex-1">
                    <p class="font-bold text-xl mb-1">Butuh Bantuan?</p>
                    <p class="text-cyan-400">Tim support kami siap membantu 24/7 jika kamu mengalami kendala.</p>
                </div>
                <button class="bg-white text-black px-8 py-3 font-bold border-2 border-white hover:bg-cyan-400 transition">
                    Hubungi Admin
                </button>
            </div>
        </div>

    </div>
</div>

<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('✅ Nomor rekening berhasil disalin!');
    });
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('previewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Drag and drop functionality
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('proofImage');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-pink-500');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('border-pink-500');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-pink-500');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        previewImage({ target: fileInput });
    }
});
</script>

@endsection
