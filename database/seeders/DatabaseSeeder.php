<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan seeder role terlebih dahulu
        $this->call(RoleSeeder::class);

        // 2. Ambil data role dari database untuk mendapatkan ID-nya
        $roleAdmin = Role::where('name', 'Admin')->first();
        $roleFormulator = Role::where('name', 'Formulator')->first();
        $roleTeknisi = Role::where('name', 'Teknisi')->first();
        $roleManajer = Role::where('name', 'Manajer R&D')->first();
        $roleQA = Role::where('name', 'QA')->first();

        // 3. Daftar akun standar untuk kebutuhan aplikasi awal dan pengujian (Selenium)
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'role_id' => $roleAdmin->id ?? 1,
            ],
            [
                'name' => 'Formulator Skincare',
                'email' => 'formulator@example.com',
                'role_id' => $roleFormulator->id ?? 2,
            ],
            [
                'name' => 'Teknisi Laboratorium',
                'email' => 'teknisi@example.com',
                'role_id' => $roleTeknisi->id ?? 3,
            ],
            [
                'name' => 'Manajer R&D',
                'email' => 'manajer@example.com',
                'role_id' => $roleManajer->id ?? 4,
            ],
            [
                'name' => 'Quality Assurance',
                'email' => 'qa@example.com',
                'role_id' => $roleQA->id ?? 5,
            ],
        ];

        // 4. Masukkan ke database dengan password seragam 'password'
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Hindari duplikasi jika seeder dijalankan ulang
                [
                    'name' => $userData['name'],
                    'role_id' => $userData['role_id'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}