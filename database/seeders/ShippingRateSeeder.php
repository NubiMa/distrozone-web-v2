<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     * Tarif berdasarkan brief LSP.txt
     */
    public function run(): void
    {
        $rates = [
            // DKI Jakarta
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Pusat', 'rate_per_kg' => 24000],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Selatan', 'rate_per_kg' => 24000],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Barat', 'rate_per_kg' => 24000],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Timur', 'rate_per_kg' => 24000],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Utara', 'rate_per_kg' => 24000],
            ['province' => 'DKI Jakarta', 'city' => 'Kepulauan Seribu', 'rate_per_kg' => 24000],

            // Banten (termasuk Tangerang)
            ['province' => 'Banten', 'city' => 'Tangerang', 'rate_per_kg' => 25000],
            ['province' => 'Banten', 'city' => 'Tangerang Selatan', 'rate_per_kg' => 25000],
            ['province' => 'Banten', 'city' => 'Serang', 'rate_per_kg' => 25000],
            ['province' => 'Banten', 'city' => 'Cilegon', 'rate_per_kg' => 25000],
            ['province' => 'Banten', 'city' => 'Pandeglang', 'rate_per_kg' => 25000],
            ['province' => 'Banten', 'city' => 'Lebak', 'rate_per_kg' => 25000],

            // Jawa Barat (Depok, Bekasi, Bogor + lainnya)
            ['province' => 'Jawa Barat', 'city' => 'Depok', 'rate_per_kg' => 24000],
            ['province' => 'Jawa Barat', 'city' => 'Bekasi', 'rate_per_kg' => 25000],
            ['province' => 'Jawa Barat', 'city' => 'Bogor', 'rate_per_kg' => 27000],
            ['province' => 'Jawa Barat', 'city' => 'Bandung', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Cimahi', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Sukabumi', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Tasikmalaya', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Cirebon', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Garut', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Karawang', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Subang', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Purwakarta', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Sumedang', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Indramayu', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Kuningan', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Majalengka', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Cianjur', 'rate_per_kg' => 31000],
            ['province' => 'Jawa Barat', 'city' => 'Banjar', 'rate_per_kg' => 31000],

            // DI Yogyakarta
            ['province' => 'DI Yogyakarta', 'city' => 'Yogyakarta', 'rate_per_kg' => 39000],
            ['province' => 'DI Yogyakarta', 'city' => 'Sleman', 'rate_per_kg' => 39000],
            ['province' => 'DI Yogyakarta', 'city' => 'Bantul', 'rate_per_kg' => 39000],
            ['province' => 'DI Yogyakarta', 'city' => 'Gunung Kidul', 'rate_per_kg' => 39000],
            ['province' => 'DI Yogyakarta', 'city' => 'Kulon Progo', 'rate_per_kg' => 39000],

            // Jawa Tengah
            ['province' => 'Jawa Tengah', 'city' => 'Semarang', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Solo', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Surakarta', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Magelang', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Salatiga', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Pekalongan', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Tegal', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Kudus', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Jepara', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Demak', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Purwokerto', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Cilacap', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Brebes', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Kendal', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Klaten', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Boyolali', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Sragen', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Karanganyar', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Wonogiri', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Rembang', 'rate_per_kg' => 39000],
            ['province' => 'Jawa Tengah', 'city' => 'Blora', 'rate_per_kg' => 39000],

            // Jawa Timur
            ['province' => 'Jawa Timur', 'city' => 'Surabaya', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Malang', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Sidoarjo', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Gresik', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Pasuruan', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Mojokerto', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Kediri', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Blitar', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Madiun', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Probolinggo', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Jember', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Banyuwangi', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Lumajang', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Lamongan', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Tuban', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Bojonegoro', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Ngawi', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Magetan', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Ponorogo', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Trenggalek', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Tulungagung', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Nganjuk', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Jombang', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Situbondo', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Bondowoso', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Bangkalan', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Sampang', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Pamekasan', 'rate_per_kg' => 47000],
            ['province' => 'Jawa Timur', 'city' => 'Sumenep', 'rate_per_kg' => 47000],
        ];

        foreach ($rates as $rate) {
            ShippingRate::updateOrCreate(
                [
                    'province' => $rate['province'],
                    'city' => $rate['city'],
                ],
                [
                    'rate_per_kg' => $rate['rate_per_kg'],
                    'is_active' => true,
                ]
            );
        }
    }
}
