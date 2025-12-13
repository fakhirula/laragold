<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            BranchesTableSeeder::class,
            BrandsTableSeeder::class,
            ProductsTableSeeder::class,
            PricesTableSeeder::class,
            TransactionsTableSeeder::class,
            UserPortfolioTableSeeder::class,
        ]);
    }
}
