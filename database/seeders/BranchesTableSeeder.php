<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run(): void
    {    
        $branches = [
            [
                'name' => 'Cabang Jakarta Pusat',
                'address' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                'phone' => '021-1234567',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'is_active' => true,
            ],
            [
                'name' => 'Cabang Surabaya',
                'address' => 'Jl. Tunjungan No. 10, Surabaya',
                'phone' => '031-7654321',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'is_active' => true,
            ],
            [
                'name' => 'Cabang Bandung',
                'address' => 'Jl. Asia Afrika No. 5, Bandung',
                'phone' => '022-9876543',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->updateOrInsert(
                ['name' => $branch['name']],
                [
                    'address' => $branch['address'],
                    'phone' => $branch['phone'] ?? null,
                    'city' => $branch['city'] ?? null,
                    'province' => $branch['province'] ?? null,
                    'is_active' => $branch['is_active'] ?? true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
