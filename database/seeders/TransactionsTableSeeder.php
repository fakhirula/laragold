<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id', 'email');
        $products = DB::table('products')->pluck('id', 'name');
        $partners = DB::table('service_partners')->pluck('id', 'name');
        $now = now();

        // Client buys 0.5g Antam at 1,150,000 per gram
        $txId = DB::table('transactions')->insertGetId([
            'user_id' => $users->get('client@laragold.local') ?? $users->values()->first() ?? 1,
            'type' => 'buy',
            'status' => 'completed',
            'total_amount_rp' => 575000.00,
            'partner_id' => $partners->get('Mitra Antam Jakarta') ?? null,
            'transaction_date' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('transaction_details')->insert([
            [
                'transaction_id' => $txId,
                'product_id' => $products->get('Antam LM 1g') ?? $products->values()->first() ?? 1,
                'weight_g' => 0.500000,
                'price_per_gram_at_time' => 1150000.000000,
                'subtotal_rp' => 575000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
