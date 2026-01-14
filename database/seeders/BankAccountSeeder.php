<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     * Data rekening bank untuk pembayaran transfer
     */
    public function run(): void
    {
        $banks = [
            [
                'bank_name' => 'Bank Mandiri',
                'account_number' => '1234567890123',
                'account_holder_name' => 'DistroZone',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank BCA',
                'account_number' => '0987654321',
                'account_holder_name' => 'DistroZone',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank BNI',
                'account_number' => '1122334455667',
                'account_holder_name' => 'DistroZone',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank BRI',
                'account_number' => '998877665544332211',
                'account_holder_name' => 'DistroZone',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($banks as $bank) {
            BankAccount::updateOrCreate(
                ['bank_name' => $bank['bank_name']],
                $bank
            );
        }
    }
}
