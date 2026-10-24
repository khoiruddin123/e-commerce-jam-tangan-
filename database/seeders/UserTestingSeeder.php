<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTestingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        DB::table('users')->updateOrInsert(
            ['username' => 'admin'],
            [
                'nama' => 'Admin Toko',
                'email' => 'admin@jamtangan.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Surakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Akun Pelanggan (Javier)
        DB::table('users')->updateOrInsert(
            ['username' => 'firaas'],
            [
                'nama' => 'Firaas Javier',
                'email' => 'firaas@jamtangan.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'no_telepon' => '089876543210',
                'alamat' => 'Surakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}