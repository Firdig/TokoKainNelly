<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Seeder untuk data pesanan contoh.
 * Membuat sampel pesanan dari berbagai kanal (POS, BOPS, Delivery)
 * untuk demo dashboard, laporan, dan tracking pelanggan.
 */
class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $staff = User::where('role', 'staff')->first();
        $customers = User::where('role', 'customer')->get();
        $variants = ProductVariant::with('product')->get();

        if ($variants->isEmpty()) {
            $this->command->warn('⚠️  Jalankan ProductSeeder terlebih dahulu!');
            return;
        }

        $orderCount = 0;

        // ═══════════════════════════════════════════
        // 1. POS Transactions (kasir di toko fisik)
        // ═══════════════════════════════════════════
        for ($i = 0; $i < 8; $i++) {
            $selectedVariants = $variants->random(rand(1, 3));
            $totalAmount = 0;
            $items = [];

            foreach ($selectedVariants as $variant) {
                $qty = rand(1, 5) + (rand(0, 1) ? 0.5 : 0);
                $price = $variant->product->price;
                $totalAmount += $price * $qty;
                $items[] = [
                    'product_variant_id' => $variant->id,
                    'quantity'           => $qty,
                    'price'              => $price,
                ];
            }

            $createdAt = Carbon::today()->subDays(rand(0, 14))->addHours(rand(8, 17))->addMinutes(rand(0, 59));

            $order = Order::create([
                'invoice_number'   => 'POS-' . $createdAt->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'transaction_type' => 'pos',
                'status'           => 'completed',
                'total_amount'     => $totalAmount,
                'user_id'          => $staff?->id ?? $admin?->id,
                'payment_method'   => collect(['cash', 'qris', 'transfer_bca'])->random(),
                'customer_name'    => collect(['Ibu Sari', 'Pak Budi', 'Mbak Rina', 'Bu Dewi', 'Pak Hadi', 'Mbak Ayu', 'Bu Yanti', 'Pak Joko'])->random(),
                'customer_phone'   => '08' . rand(1000000000, 9999999999),
                'created_at'       => $createdAt,
                'updated_at'       => $createdAt,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
            $orderCount++;
        }

        // ═══════════════════════════════════════════
        // 2. BOPS Orders (Click & Collect)
        // ═══════════════════════════════════════════
        $bopsStatuses = ['pending', 'ready_for_pickup', 'completed', 'completed'];
        
        foreach ($bopsStatuses as $idx => $status) {
            $selectedVariants = $variants->random(rand(1, 2));
            $totalAmount = 0;
            $items = [];

            foreach ($selectedVariants as $variant) {
                $qty = rand(1, 4) + (rand(0, 1) ? 0.5 : 0);
                $price = $variant->product->price;
                $totalAmount += $price * $qty;
                $items[] = [
                    'product_variant_id' => $variant->id,
                    'quantity'           => $qty,
                    'price'              => $price,
                ];
            }

            $createdAt = Carbon::today()->subDays(rand(0, 7))->addHours(rand(9, 20));
            $customer = $customers->isNotEmpty() ? $customers->random() : null;

            $order = Order::create([
                'invoice_number'       => 'BOPS-' . $createdAt->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'transaction_type'     => 'bops',
                'status'               => $status,
                'total_amount'         => $totalAmount,
                'user_id'              => $customer?->id,
                'pickup_code'          => strtoupper(Str::random(6)),
                'estimated_pickup_at'  => $createdAt->copy()->addHours(2),
                'payment_method'       => collect(['transfer_bca', 'qris', 'cod'])->random(),
                'customer_name'        => $customer?->name ?? 'Pelanggan BOPS ' . ($idx + 1),
                'customer_phone'       => '08' . rand(1000000000, 9999999999),
                'created_at'           => $createdAt,
                'updated_at'           => $createdAt,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
            $orderCount++;
        }

        // ═══════════════════════════════════════════
        // 3. Delivery Orders (Pengiriman)
        // ═══════════════════════════════════════════
        $deliveryStatuses = ['pending', 'shipped', 'completed', 'completed', 'cancelled'];
        $alamat = [
            'Jl. Merdeka No. 45, Kepanjen, Malang 65163',
            'Jl. Raya Gondanglegi No. 12, Malang 65174',
            'Jl. Ahmad Yani No. 88, Kota Malang 65126',
            'Perum Griya Asri Blok C-7, Pakisaji, Malang',
            'Jl. Soekarno Hatta No. 200, Lowokwaru, Malang',
        ];

        foreach ($deliveryStatuses as $idx => $status) {
            $selectedVariants = $variants->random(rand(1, 3));
            $totalAmount = 0;
            $items = [];

            foreach ($selectedVariants as $variant) {
                $qty = rand(1, 6);
                $price = $variant->product->price;
                $totalAmount += $price * $qty;
                $items[] = [
                    'product_variant_id' => $variant->id,
                    'quantity'           => $qty,
                    'price'              => $price,
                ];
            }

            $createdAt = Carbon::today()->subDays(rand(0, 10))->addHours(rand(7, 22));
            $customer = $customers->isNotEmpty() ? $customers->random() : null;

            $order = Order::create([
                'invoice_number'   => 'DLV-' . $createdAt->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'transaction_type' => 'delivery',
                'status'           => $status,
                'total_amount'     => $totalAmount,
                'user_id'          => $customer?->id,
                'payment_method'   => collect(['transfer_bca', 'qris'])->random(),
                'customer_name'    => $customer?->name ?? 'Pelanggan Delivery ' . ($idx + 1),
                'customer_phone'   => '08' . rand(1000000000, 9999999999),
                'delivery_address' => $alamat[$idx],
                'created_at'       => $createdAt,
                'updated_at'       => $createdAt,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
            $orderCount++;
        }

        $this->command->info("✅ OrderSeeder: {$orderCount} pesanan berhasil di-seed (POS, BOPS, Delivery).");
    }
}
