<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoldBrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gold_brands')->insert([
            ['name' => 'Antam', 'metal_type' => 'Gold'],
            ['name' => 'UBS', 'metal_type' => 'Gold'],
            ['name' => 'Pegadaian', 'metal_type' => 'Gold'],
        ]);
    }
}
