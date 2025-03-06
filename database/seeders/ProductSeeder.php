<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_number' => 'PN-202503061740275797',
                'product_name' => 'Elbow 90°',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Sambungan pipa dengan sudut 90° untuk perubahan arah aliran.',
                'unit' => 'pcs',
                'price' => 5000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061742238065',
                'product_name' => 'Tee',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Sambungan pipa berbentuk T untuk percabangan aliran.',
                'unit' => 'pcs',
                'price' => 7000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061742476732',
                'product_name' => 'Reducing Tee',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Tee dengan ukuran cabang yang lebih kecil untuk mengurangi aliran.',
                'unit' => 'pcs',
                'price' => 7500,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743143237',
                'product_name' => 'Cap',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Penutup ujung pipa untuk menghentikan aliran.',
                'unit' => 'pcs',
                'price' => 3000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743331141',
                'product_name' => 'Bushing',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Adaptor untuk menghubungkan pipa dengan diameter berbeda.',
                'unit' => 'pcs',
                'price' => 4000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743333287',
                'product_name' => 'Nipple',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Pipa pendek berulir untuk menyambungkan dua fitting.',
                'unit' => 'pcs',
                'price' => 3500,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743389123',
                'product_name' => 'Locknut',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Mur pengunci untuk mengamankan fitting pada tempatnya.',
                'unit' => 'pcs',
                'price' => 2000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743398765',
                'product_name' => 'Plug',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Penyumbat ujung pipa atau lubang pada fitting.',
                'unit' => 'pcs',
                'price' => 2500,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743328365',
                'product_name' => 'Floor Flange',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Flange untuk menghubungkan pipa ke lantai atau permukaan datar.',
                'unit' => 'pcs',
                'price' => 8000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_number' => 'PN-202503061743098728',
                'product_name' => 'Union',
                'material' => 'Besi Mampu Tempa',
                'description' => 'Sambungan pipa yang dapat dilepas tanpa memutar pipa.',
                'unit' => 'pcs',
                'price' => 9000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
