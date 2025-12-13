<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Galeri24', 'metal_type' => 'Gold'],
            ['name' => 'UBS', 'metal_type' => 'Gold'],
            ['name' => 'Antam', 'metal_type' => 'Gold'],
            ['name' => 'Lotus Archi', 'metal_type' => 'Gold'],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->updateOrInsert(
                ['name' => $brand['name']],
                ['metal_type' => $brand['metal_type']]
            );
        }
    }
}
