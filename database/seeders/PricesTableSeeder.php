<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('products')->pluck('id', 'name');
        $now = now();
        $rows = [];
        foreach (['Antam LM 1g', 'UBS LM 1g', 'Pegadaian Digital Gold'] as $productName) {
            $pid = $products->get($productName);
            if (!$pid) continue;
            $rows[] = [
                'product_id' => $pid,
                'price_type' => 'buy',
                'price_per_gram' => 1100000.000000,
                'recorded_at' => $now,
            ];
            $rows[] = [
                'product_id' => $pid,
                'price_type' => 'sell',
                'price_per_gram' => 1150000.000000,
                'recorded_at' => $now,
            ];
        }
        if ($rows) {
            DB::table('prices')->insert($rows);
        }
    }
}
