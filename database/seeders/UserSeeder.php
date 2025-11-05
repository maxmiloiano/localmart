<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@localmart.com'],
            [
                'name' => 'Admin LocalMart',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'alamat' => 'Jakarta',
                'no_hp' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dewistore@gmail.com'],
            [
                'name' => 'Toko Bu Dewi',
                'password' => Hash::make('seller123'),
                'role' => 'seller',
                'alamat' => 'Bandung',
                'no_hp' => '081223344556',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('buyer123'),
                'role' => 'buyer',
                'alamat' => 'Yogyakarta',
                'no_hp' => '081333444555',
            ]
        );
    }
}
