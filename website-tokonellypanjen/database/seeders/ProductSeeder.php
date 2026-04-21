<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

/**
 * Seeder untuk data produk kain beserta varian warna.
 * Menggunakan data realistis toko kain tekstil UMKM.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ═══════════════════════════════════════════
            // KATUN
            // ═══════════════════════════════════════════
            [
                'name'          => 'Katun Jepang Premium',
                'description'   => 'Kain katun jepang berkualitas tinggi dengan serat halus dan adem dipakai sehari-hari. Cocok untuk kemeja, blouse, dan gamis. Tidak mudah kusut dan menyerap keringat dengan baik.',
                'price'         => 65000,
                'fabric_type'   => 'Katun',
                'texture'       => 'Halus Lembut',
                'comfort_level' => 5,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Cotton Japan',
                'fabric_care'   => 'Cuci dengan air dingin, jemur di tempat teduh',
                'variants'      => [
                    ['color_name' => 'Putih Tulang',   'hex_code' => '#FAEBD7', 'stock' => 120],
                    ['color_name' => 'Hitam Pekat',     'hex_code' => '#1A1A1A', 'stock' => 95],
                    ['color_name' => 'Navy Blue',       'hex_code' => '#1B2A4A', 'stock' => 80],
                    ['color_name' => 'Dusty Pink',      'hex_code' => '#DCAE96', 'stock' => 65],
                    ['color_name' => 'Sage Green',      'hex_code' => '#9CAF88', 'stock' => 50],
                ],
            ],
            [
                'name'          => 'Katun Rayon Motif Bunga',
                'description'   => 'Katun rayon lembut dengan motif bunga tropis yang cantik. Bahan jatuh dan flowy, sangat cocok untuk dress dan rok panjang. Nyaman dipakai di iklim tropis.',
                'price'         => 55000,
                'fabric_type'   => 'Katun',
                'texture'       => 'Jatuh Flowy',
                'comfort_level' => 4,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '70% Cotton, 30% Rayon',
                'fabric_care'   => 'Cuci manual, jangan diperas terlalu kuat',
                'variants'      => [
                    ['color_name' => 'Bunga Merah',     'hex_code' => '#C41E3A', 'stock' => 45],
                    ['color_name' => 'Bunga Kuning',    'hex_code' => '#DAA520', 'stock' => 60],
                    ['color_name' => 'Bunga Biru',      'hex_code' => '#4169E1', 'stock' => 55],
                ],
            ],
            [
                'name'          => 'Katun Toyobo',
                'description'   => 'Kain katun toyobo dengan karakter tebal namun tetap adem. Sering digunakan untuk seragam, kemeja formal, dan gamis premium. Warna tidak mudah luntur.',
                'price'         => 75000,
                'fabric_type'   => 'Katun',
                'texture'       => 'Halus Lembut',
                'comfort_level' => 5,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Toyobo Cotton',
                'fabric_care'   => 'Bisa dicuci mesin, suhu rendah',
                'variants'      => [
                    ['color_name' => 'Abu Muda',        'hex_code' => '#B0B0B0', 'stock' => 100],
                    ['color_name' => 'Coklat Tua',      'hex_code' => '#5C4033', 'stock' => 70],
                    ['color_name' => 'Hijau Army',      'hex_code' => '#4B5320', 'stock' => 55],
                    ['color_name' => 'Maroon',          'hex_code' => '#800000', 'stock' => 85],
                ],
            ],

            // ═══════════════════════════════════════════
            // SUTRA
            // ═══════════════════════════════════════════
            [
                'name'          => 'Sutra ATBM Garut',
                'description'   => 'Sutra alat tenun bukan mesin (ATBM) asal Garut dengan kilau mewah. Setiap helai ditenun dengan tangan terampil perajin lokal. Cocok untuk kebaya dan busana pesta.',
                'price'         => 350000,
                'fabric_type'   => 'Sutra',
                'texture'       => 'Licin Mengkilap',
                'comfort_level' => 5,
                'branch_id'     => 1,
                'width'         => '1.15 meter',
                'composition'   => '100% Silk',
                'fabric_care'   => 'Dry clean recommended, setrika suhu rendah',
                'variants'      => [
                    ['color_name' => 'Emas Elegan',     'hex_code' => '#D4AF37', 'stock' => 15],
                    ['color_name' => 'Merah Marun',     'hex_code' => '#800020', 'stock' => 12],
                    ['color_name' => 'Biru Safir',      'hex_code' => '#0F52BA', 'stock' => 10],
                ],
            ],

            // ═══════════════════════════════════════════
            // SATIN
            // ═══════════════════════════════════════════
            [
                'name'          => 'Satin Silk Premium',
                'description'   => 'Kain satin silk dengan permukaan licin mengkilap sangat cocok untuk busana pesta, gaun, dan hijab premium. Memberikan kesan mewah dan elegan pada setiap busana.',
                'price'         => 85000,
                'fabric_type'   => 'Satin',
                'texture'       => 'Licin Mengkilap',
                'comfort_level' => 4,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Polyester Satin',
                'fabric_care'   => 'Cuci manual dengan air dingin, setrika suhu rendah',
                'variants'      => [
                    ['color_name' => 'Rose Gold',       'hex_code' => '#B76E79', 'stock' => 40],
                    ['color_name' => 'Silver',          'hex_code' => '#C0C0C0', 'stock' => 35],
                    ['color_name' => 'Champagne',       'hex_code' => '#F7E7CE', 'stock' => 50],
                    ['color_name' => 'Emerald',         'hex_code' => '#046307', 'stock' => 30],
                    ['color_name' => 'Midnight Black',  'hex_code' => '#191970', 'stock' => 45],
                ],
            ],

            // ═══════════════════════════════════════════
            // POLYESTER
            // ═══════════════════════════════════════════
            [
                'name'          => 'Polyester Twist Polos',
                'description'   => 'Kain polyester twist yang sering dipakai untuk seragam kantor, jas, dan celana formal. Bahan tidak mudah kusut, tahan lama, dan perawatan mudah.',
                'price'         => 45000,
                'fabric_type'   => 'Polyester',
                'texture'       => 'Tebal Kaku',
                'comfort_level' => 3,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Polyester',
                'fabric_care'   => 'Bisa dicuci mesin, tahan setrika panas',
                'variants'      => [
                    ['color_name' => 'Hitam',           'hex_code' => '#000000', 'stock' => 200],
                    ['color_name' => 'Abu-Abu Tua',     'hex_code' => '#555555', 'stock' => 150],
                    ['color_name' => 'Putih',           'hex_code' => '#FFFFFF', 'stock' => 130],
                    ['color_name' => 'Navy',            'hex_code' => '#000080', 'stock' => 110],
                    ['color_name' => 'Cream',           'hex_code' => '#FFFDD0', 'stock' => 90],
                ],
            ],

            // ═══════════════════════════════════════════
            // LINEN
            // ═══════════════════════════════════════════
            [
                'name'          => 'Linen Washing Premium',
                'description'   => 'Kain linen washing yang sudah diproses sehingga lebih lembut dari linen biasa. Sangat breathable dan cocok untuk cuaca panas. Ideal untuk kemeja casual dan celana santai.',
                'price'         => 95000,
                'fabric_type'   => 'Linen',
                'texture'       => 'Kasar Bertekstur',
                'comfort_level' => 4,
                'branch_id'     => 1,
                'width'         => '1.4 meter',
                'composition'   => '100% Linen',
                'fabric_care'   => 'Cuci dingin, jemur angin, setrika saat lembab',
                'variants'      => [
                    ['color_name' => 'Broken White',    'hex_code' => '#F5F5DC', 'stock' => 35],
                    ['color_name' => 'Mocca',           'hex_code' => '#967969', 'stock' => 40],
                    ['color_name' => 'Olive',           'hex_code' => '#708238', 'stock' => 25],
                ],
            ],

            // ═══════════════════════════════════════════
            // RAYON
            // ═══════════════════════════════════════════
            [
                'name'          => 'Rayon Challis Polos',
                'description'   => 'Kain rayon challis super lembut dan jatuh. Favorit untuk gamis, rok, dan baju tidur karena bahannya yang sangat nyaman dan adem. Pilihan ekonomis dengan kualitas bagus.',
                'price'         => 35000,
                'fabric_type'   => 'Rayon',
                'texture'       => 'Jatuh Flowy',
                'comfort_level' => 4,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Viscose Rayon',
                'fabric_care'   => 'Cuci manual, jangan diperas, jemur di tempat teduh',
                'variants'      => [
                    ['color_name' => 'Lavender',        'hex_code' => '#9B89B3', 'stock' => 75],
                    ['color_name' => 'Peach',           'hex_code' => '#FFCBA4', 'stock' => 80],
                    ['color_name' => 'Mint',            'hex_code' => '#98FF98', 'stock' => 60],
                    ['color_name' => 'Mustard',         'hex_code' => '#E1AD01', 'stock' => 55],
                    ['color_name' => 'Terracotta',      'hex_code' => '#E2725B', 'stock' => 45],
                    ['color_name' => 'Coral',           'hex_code' => '#FF6F61', 'stock' => 50],
                ],
            ],

            // ═══════════════════════════════════════════
            // CHIFFON
            // ═══════════════════════════════════════════
            [
                'name'          => 'Chiffon Ceruty Baby Doll',
                'description'   => 'Kain chiffon ceruty baby doll yang ringan, transparan, dan mengalir indah. Sangat populer untuk hijab, inner, dan layering pada busana pesta.',
                'price'         => 40000,
                'fabric_type'   => 'Chiffon',
                'texture'       => 'Jatuh Flowy',
                'comfort_level' => 3,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Polyester Chiffon',
                'fabric_care'   => 'Cuci manual lembut, jangan diperas, setrika suhu rendah',
                'variants'      => [
                    ['color_name' => 'Soft Pink',       'hex_code' => '#FFB6C1', 'stock' => 70],
                    ['color_name' => 'Baby Blue',       'hex_code' => '#89CFF0', 'stock' => 65],
                    ['color_name' => 'Lilac',           'hex_code' => '#C8A2C8', 'stock' => 50],
                    ['color_name' => 'Off White',       'hex_code' => '#FAF9F6', 'stock' => 80],
                ],
            ],

            // ═══════════════════════════════════════════
            // BROKAT
            // ═══════════════════════════════════════════
            [
                'name'          => 'Brokat Cornelli Import',
                'description'   => 'Kain brokat cornelli import dengan bordir timbul detail tinggi. Material premium untuk kebaya, gaun pengantin, dan busana pesta mewah. Finishing rapi dan elegan.',
                'price'         => 180000,
                'fabric_type'   => 'Brokat',
                'texture'       => 'Kasar Bertekstur',
                'comfort_level' => 3,
                'branch_id'     => 1,
                'width'         => '1.3 meter',
                'composition'   => 'Polyester + Bordir Benang',
                'fabric_care'   => 'Dry clean only, simpan terlipat rapi',
                'variants'      => [
                    ['color_name' => 'Gold',            'hex_code' => '#FFD700', 'stock' => 20],
                    ['color_name' => 'Merah Ferrari',   'hex_code' => '#FF2800', 'stock' => 18],
                    ['color_name' => 'Biru Royal',      'hex_code' => '#002366', 'stock' => 15],
                    ['color_name' => 'Hitam Elegan',    'hex_code' => '#0B0B0B', 'stock' => 22],
                ],
            ],

            // ═══════════════════════════════════════════
            // DENIM
            // ═══════════════════════════════════════════
            [
                'name'          => 'Denim Chambray Ringan',
                'description'   => 'Kain denim chambray yang lebih ringan dari denim biasa. Cocok untuk kemeja denim casual, rompi, dan jaket ringan. Memberikan kesan stylish dan timeless.',
                'price'         => 70000,
                'fabric_type'   => 'Denim',
                'texture'       => 'Tebal Kaku',
                'comfort_level' => 3,
                'branch_id'     => 1,
                'width'         => '1.5 meter',
                'composition'   => '100% Cotton Denim',
                'fabric_care'   => 'Cuci balik, hindari pemutih, jemur balik',
                'variants'      => [
                    ['color_name' => 'Light Wash',      'hex_code' => '#6F8FAF', 'stock' => 55],
                    ['color_name' => 'Medium Blue',     'hex_code' => '#4169E1', 'stock' => 60],
                    ['color_name' => 'Dark Indigo',     'hex_code' => '#2E1A47', 'stock' => 45],
                ],
            ],

            // ═══════════════════════════════════════════
            // BATIK  
            // ═══════════════════════════════════════════
            [
                'name'          => 'Batik Cap Pekalongan',
                'description'   => 'Kain batik cap khas Pekalongan dengan motif mega mendung dan parang klasik. Warna cerah khas pesisir, cocok untuk kemeja batik, dress, dan seragam.',
                'price'         => 60000,
                'fabric_type'   => 'Batik',
                'texture'       => 'Halus Lembut',
                'comfort_level' => 4,
                'branch_id'     => 1,
                'width'         => '2.0 meter',
                'composition'   => '100% Katun Primisima',
                'fabric_care'   => 'Cuci manual dengan lerak/sabun khusus batik, jemur teduh',
                'variants'      => [
                    ['color_name' => 'Mega Mendung Biru',  'hex_code' => '#1E3A5F', 'stock' => 30],
                    ['color_name' => 'Parang Coklat',      'hex_code' => '#8B4513', 'stock' => 35],
                    ['color_name' => 'Kawung Hijau',        'hex_code' => '#2E8B57', 'stock' => 25],
                ],
            ],
            [
                'name'          => 'Batik Tulis Solo Premium',
                'description'   => 'Batik tulis asli Solo dengan motif truntum dan sidomukti. Tiap lembar dibuat handmade oleh pengrajin berpengalaman. Material katun primisima halus kelas satu.',
                'price'         => 250000,
                'fabric_type'   => 'Batik',
                'texture'       => 'Halus Lembut',
                'comfort_level' => 5,
                'branch_id'     => 1,
                'width'         => '2.0 meter',
                'composition'   => '100% Katun Primisima Grade A',
                'fabric_care'   => 'Cuci manual lembut, jangan diperas, jemur angin',
                'variants'      => [
                    ['color_name' => 'Sogan Classic',   'hex_code' => '#704214', 'stock' => 8],
                    ['color_name' => 'Truntum Hitam',   'hex_code' => '#1C1C1C', 'stock' => 10],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'];
            unset($productData['variants']);

            $product = Product::create($productData);

            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }
        }

        $this->command->info('✅ ProductSeeder: ' . count($products) . ' produk kain berhasil di-seed.');
    }
}