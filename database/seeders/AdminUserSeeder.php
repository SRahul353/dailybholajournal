<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'email' => 'admin@dailybholajournal.com',
                'name' => 'Administrator',
                'role' => 'super_admin',
                'password' => Hash::make('admin123'),
            ],
            [
                'email' => 'admin@bholatimes24.com',
                'name' => 'Administrator',
                'role' => 'super_admin',
                'password' => Hash::make('admin123'),
            ]
        ];

        foreach ($admins as $admin) {
            DB::table('users')->updateOrInsert(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'role' => $admin['role'],
                    'email_verified_at' => now(),
                    'password' => $admin['password'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
