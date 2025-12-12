<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPortfolioTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id', 'email');
        $products = DB::table('products')->pluck('id', 'name');
        DB::table('user_portfolio')->insert([
            [
                'user_id' => $users->get('client@laragold.local') ?? $users->values()->first() ?? 1,
                'product_id' => $products->get('Antam LM 1g') ?? $products->values()->first() ?? 1,
                'balance_weight_g' => 0.500000,
                'last_updated' => now(),
            ],
        ]);
    }
}
