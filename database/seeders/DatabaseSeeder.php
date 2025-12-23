<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\ShippingRate;
use App\Models\BankAccount;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $this->createUsers();
        
        // Create Categories
        $this->createCategories();
        
        // Create Products
        $this->createProducts();
        
        // Create Shipping Rates
        $this->createShippingRates();
        
        // Create Bank Accounts
        $this->createBankAccounts();
        
        // Create Settings
        $this->createSettings();
    }

    private function createUsers(): void
    {
        // Admin
        User::create([
            'name' => 'Admin DistroZone',
            'email' => 'admin@distrozone.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Cashier
        User::create([
            'name' => 'Kasir 1',
            'email' => 'cashier@distrozone.com',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

        // Sample Customer
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);
    }

    private function createCategories(): void
    {
        $categories = [
            ['name' => 'Basic Tees', 'slug' => 'basic-tees'],
            ['name' => 'Graphic Tees', 'slug' => 'graphic-tees'],
            ['name' => 'Oversized', 'slug' => 'oversized'],
            ['name' => 'Premium', 'slug' => 'premium'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => "Collection of {$category['name']}",
                'is_active' => true,
            ]);
        }
    }

    private function createProducts(): void
    {
        $categories = Category::all();
        $colors = ['Black', 'White', 'Navy', 'Grey', 'Red'];
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

        for ($i = 1; $i <= 10; $i++) {
            $category = $categories->random();
            
            $product = Product::create([
                'category_id' => $category->id,
                'name' => "Distro T-Shirt Model {$i}",
                'slug' => "distro-tshirt-model-{$i}",
                'sku' => "DZ-TS-" . str_pad($i, 4, '0', STR_PAD_LEFT),
                'description' => "High quality distro t-shirt with unique design. Made from premium cotton material.",
                'base_price' => rand(100, 300) * 1000, // 100k - 300k
                'cost_price' => rand(50, 150) * 1000,  // 50k - 150k
                'weight' => 300, // grams
                'is_active' => true,
                'is_featured' => $i <= 3,
            ]);

            // Create variants
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color' => $color,
                        'size' => $size,
                        'sku' => "{$product->sku}-{$color}-{$size}",
                        'price' => $product->base_price,
                        'stock' => rand(5, 50),
                        'min_stock' => 5,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }

    private function createShippingRates(): void
    {
        $rates = [
            // Jakarta Area
            ['city' => 'Jakarta Pusat', 'province' => 'DKI Jakarta', 'rate' => 24000],
            ['city' => 'Jakarta Selatan', 'province' => 'DKI Jakarta', 'rate' => 24000],
            ['city' => 'Jakarta Utara', 'province' => 'DKI Jakarta', 'rate' => 24000],
            ['city' => 'Jakarta Barat', 'province' => 'DKI Jakarta', 'rate' => 24000],
            ['city' => 'Jakarta Timur', 'province' => 'DKI Jakarta', 'rate' => 24000],
            
            // Jabodetabek
            ['city' => 'Depok', 'province' => 'West Java', 'rate' => 24000],
            ['city' => 'Bekasi', 'province' => 'West Java', 'rate' => 25000],
            ['city' => 'Tangerang', 'province' => 'Banten', 'rate' => 25000],
            ['city' => 'Tangerang Selatan', 'province' => 'Banten', 'rate' => 25000],
            ['city' => 'Bogor', 'province' => 'West Java', 'rate' => 27000],
            
            // West Java
            ['city' => 'Bandung', 'province' => 'West Java', 'rate' => 31000],
            ['city' => 'Cirebon', 'province' => 'West Java', 'rate' => 31000],
            ['city' => 'Sukabumi', 'province' => 'West Java', 'rate' => 31000],
            
            // Central Java
            ['city' => 'Semarang', 'province' => 'Central Java', 'rate' => 39000],
            ['city' => 'Solo', 'province' => 'Central Java', 'rate' => 39000],
            ['city' => 'Yogyakarta', 'province' => 'Yogyakarta', 'rate' => 39000],
            
            // East Java
            ['city' => 'Surabaya', 'province' => 'East Java', 'rate' => 47000],
            ['city' => 'Malang', 'province' => 'East Java', 'rate' => 47000],
            ['city' => 'Sidoarjo', 'province' => 'East Java', 'rate' => 47000],
        ];

        foreach ($rates as $rate) {
            ShippingRate::create([
                'city' => $rate['city'],
                'province' => $rate['province'],
                'rate_per_kg' => $rate['rate'],
                'is_active' => true,
            ]);
        }
    }

    private function createBankAccounts(): void
    {
        $banks = [
            [
                'bank_name' => 'Bank Mandiri',
                'account_number' => '1234567890',
                'account_holder_name' => 'DistroZone',
            ],
            [
                'bank_name' => 'Bank BCA',
                'account_number' => '9876543210',
                'account_holder_name' => 'DistroZone',
            ],
        ];

        foreach ($banks as $index => $bank) {
            BankAccount::create([
                'bank_name' => $bank['bank_name'],
                'account_number' => $bank['account_number'],
                'account_holder_name' => $bank['account_holder_name'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function createSettings(): void
    {
        $settings = [
            [
                'key' => 'store_name',
                'value' => 'DistroZone',
                'type' => 'string',
                'group' => 'store',
            ],
            [
                'key' => 'online_store_open_hour',
                'value' => '10',
                'type' => 'integer',
                'group' => 'operating_hours',
            ],
            [
                'key' => 'online_store_close_hour',
                'value' => '17',
                'type' => 'integer',
                'group' => 'operating_hours',
            ],
            [
                'key' => 'tshirt_weight_grams',
                'value' => '300',
                'type' => 'integer',
                'group' => 'shipping',
            ],
            [
                'key' => 'max_tshirts_per_kg',
                'value' => '3',
                'type' => 'integer',
                'group' => 'shipping',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}