<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $brands = DB::table('gold_brands')->pluck('id', 'name');

        DB::table('products')->insert([
            [
                'brand_id' => $brands->get('Antam') ?? 1,
                'name' => 'Antam LM 1g',
                'purity_pct' => 99.99,
                'weight_g' => 1.000,
                'is_physical' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => $brands->get('UBS') ?? 2,
                'name' => 'UBS LM 1g',
                'purity_pct' => 99.99,
                'weight_g' => 1.000,
                'is_physical' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => $brands->get('Pegadaian') ?? 3,
                'name' => 'Pegadaian Digital Gold',
                'purity_pct' => 99.99,
                'weight_g' => 0.000,
                'is_physical' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
