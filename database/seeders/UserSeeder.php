<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@waskita.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Supervisor
        User::create([
            'name' => 'Supervisor Lapangan',
            'email' => 'spv@waskita.com',
            'password' => Hash::make('password123'),
            'role' => 'supervisor',
        ]);

        // 3. Akun Personel Security
        User::create([
            'name' => 'Komandan Regu',
            'email' => 'personel@waskita.com',
            'password' => Hash::make('password123'),
            'role' => 'personel',
        ]);

        // 4. Akun Klien
        User::create([
            'name' => 'PT Klien Sejahtera',
            'email' => 'klien@waskita.com',
            'password' => Hash::make('password123'),
            'role' => 'klien',
        ]);
    }
}
