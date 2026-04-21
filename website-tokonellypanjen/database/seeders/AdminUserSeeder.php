<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@tokonelly.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'staff@tokonelly.com'],
            [
                'name' => 'Staff Toko',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );
    }
}
