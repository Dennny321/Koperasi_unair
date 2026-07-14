<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('  Seeding Koperasi Pegawai UNAIR');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $this->call([
            UserSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('  ✅ Seeding selesai!');
        $this->command->info('');
        $this->command->info('  Akun login:');
        $this->command->info('  ┌─────────────────────────────────────┐');
        $this->command->info('  │ ADMIN                               │');
        $this->command->info('  │  Email    : admin@koperasi.com      │');
        $this->command->info('  │  Password : password                │');
        $this->command->info('  ├─────────────────────────────────────┤');
        $this->command->info('  │ KASIR                               │');
        $this->command->info('  │  Email    : kasir@koperasi.com      │');
        $this->command->info('  │  Password : password                │');
        $this->command->info('  ├─────────────────────────────────────┤');
        $this->command->info('  │ MEMBER                              │');
        $this->command->info('  │  Email    : member@koperasi.com     │');
        $this->command->info('  │  No HP    : 081200000003            │');
        $this->command->info('  │  Password : password                │');
        $this->command->info('  │  Poin     : 500                     │');
        $this->command->info('  └─────────────────────────────────────┘');
        $this->command->info('');
    }
}
