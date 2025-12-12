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
        // Ensure roles exist before users
        $roles = DB::table('roles')->pluck('id', 'name');

        $now = now();
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@laragold.local',
                'password' => Hash::make('admin123'),
                'role_id' => $roles->get('Administrator') ?? 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@laragold.local',
                'password' => Hash::make('supervisor123'),
                'role_id' => $roles->get('Supervisor') ?? 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Client Without Profile',
                'email' => 'clientwithoutprofile@laragold.local',
                'password' => Hash::make('client123'),
                'role_id' => $roles->get('Client') ?? 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Client With Profile',
                'email' => 'clientwithprofile@laragold.local',
                'password' => Hash::make('client123'),
                'role_id' => $roles->get('Client') ?? 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
