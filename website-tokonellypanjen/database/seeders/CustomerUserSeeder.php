<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk user pelanggan demo.
 * Membuat beberapa akun customer agar fitur order tracking & checkout bisa diuji.
 */
class CustomerUserSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name'     => 'Siti Nurhaliza',
                'email'    => 'siti@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Ahmad Fauzi',
                'email'    => 'ahmad@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Rina Wulandari',
                'email'    => 'rina@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Dewi Susanti',
                'email'    => 'dewi@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
            ],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }

        $this->command->info('✅ CustomerUserSeeder: ' . count($customers) . ' akun pelanggan berhasil di-seed.');
    }
}
