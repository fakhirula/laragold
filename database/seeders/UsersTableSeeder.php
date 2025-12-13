<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist before users and fetch role IDs
        $roles = DB::table('roles')->pluck('id', 'name');

        $now = now();
        DB::table('users')->insert([
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@laragold.local',
                'password' => Hash::make('superadmin123'),
                'role_id' => $roles['superadmin'] ?? 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@laragold.local',
                'password' => Hash::make('admin123'),
                'role_id' => $roles['admin'] ?? 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Branch',
                'email' => 'branch@laragold.local',
                'password' => Hash::make('branch123'),
                'role_id' => $roles['branch'] ?? 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Client Without Profile',
                'email' => 'clientwithoutprofile@laragold.local',
                'password' => Hash::make('client123'),
                'role_id' => $roles['client'] ?? 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Client With Profile',
                'email' => 'clientwithprofile@laragold.local',
                'password' => Hash::make('client123'),
                'role_id' => $roles['client'] ?? 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
