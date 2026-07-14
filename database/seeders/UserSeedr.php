<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Pegawai User
        User::create([
            'name' => 'Pegawai',
            'email' => 'pegawai@example.com',
            'phone_number' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'email_verified_at' => now(),
        ]);
    }
}