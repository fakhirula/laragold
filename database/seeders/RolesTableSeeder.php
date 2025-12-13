<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Superadmin'],
            ['id' => 2, 'name' => 'Admin'],
            ['id' => 3, 'name' => 'Branch'],
            ['id' => 4, 'name' => 'Client'],
        ]);
    }
}
