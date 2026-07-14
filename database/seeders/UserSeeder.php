<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // ── ADMIN ──────────────────────────────────────────
            [
                'name'        => 'Admin Koperasi',
                'email'       => 'admin@koperasi.com',
                'no_telepon'  => '081200000001',
                'password'    => Hash::make('password'),
                'role'        => 'admin',
                'saldo_poin'  => 0,
            ],

            // ── KASIR ──────────────────────────────────────────
            [
                'name'        => 'Kasir Koperasi',
                'email'       => 'kasir@koperasi.com',
                'no_telepon'  => '081200000002',
                'password'    => Hash::make('password'),
                'role'        => 'kasir',
                'saldo_poin'  => 0,
            ],

            // ── MEMBER ─────────────────────────────────────────
            [
                'name'        => 'Budi Santoso',
                'email'       => 'member@koperasi.com',
                'no_telepon'  => '081200000003',
                'password'    => Hash::make('password'),
                'role'        => 'member',
                'saldo_poin'  => 500,
            ],
            [
                'name'        => 'Siti Rahayu',
                'email'       => 'siti@koperasi.com',
                'no_telepon'  => '081200000004',
                'password'    => Hash::make('password'),
                'role'        => 'member',
                'saldo_poin'  => 250,
            ],
            [
                'name'        => 'Andi Wijaya',
                'email'       => 'andi@koperasi.com',
                'no_telepon'  => '081200000005',
                'password'    => Hash::make('password'),
                'role'        => 'member',
                'saldo_poin'  => 1000,
            ],
        ];

        foreach ($users as $user) {
            // Cek berdasarkan email atau no_telepon agar tidak duplikat
            $exists = DB::table('users')
                ->where('email', $user['email'])
                ->orWhere('no_telepon', $user['no_telepon'])
                ->exists();

            if (!$exists) {
                DB::table('users')->insert(array_merge($user, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("  ✓ Created: [{$user['role']}] {$user['name']} ({$user['email']})");
            } else {
                $this->command->warn("  ⚠ Skipped (already exists): {$user['email']}");
            }
        }
    }
}
