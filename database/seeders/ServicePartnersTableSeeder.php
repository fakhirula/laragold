<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePartnersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('service_partners')->insert([
            [
                'name' => 'Mitra Antam Jakarta',
                'address' => 'Jl. Sudirman No. 1, Jakarta',
                'contact_person' => 'Budi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UBS Surabaya Counter',
                'address' => 'Jl. Darmo No. 23, Surabaya',
                'contact_person' => 'Sari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
