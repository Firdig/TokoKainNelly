<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Master seeder that orchestrates all seeders in dependency order.
 *
 * Usage:
 *   php artisan db:seed                  — Run all seeders
 *   php artisan db:seed --class=ProductSeeder — Run specific seeder
 *   php artisan migrate:fresh --seed     — Reset DB + seed
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Order matters: Users → Products → Orders → Stock Audits.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,      // 1. Admin + Staff accounts
            CustomerUserSeeder::class,   // 2. Customer demo accounts
            ProductSeeder::class,        // 3. Products + Variants (depends on nothing)
            OrderSeeder::class,          // 4. Sample orders (depends on users + variants)
            StockAuditSeeder::class,     // 5. Stock opname records (depends on variants + users)
        ]);
    }
}
