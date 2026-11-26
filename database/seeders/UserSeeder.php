<?php

namespace Database\Seeders;

use App\Models\Donatur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Modul 6 Soal 5: password admin TIDAK lagi "password"; dibaca dari .env (tidak di-commit)
        $passwordAdmin = env('SEED_ADMIN_PASSWORD');
        abort_if(blank($passwordAdmin), 500, 'Isi SEED_ADMIN_PASSWORD di .env sebelum seeding.');

        $passwordPerRole = [
            'admin'   => $passwordAdmin,
            'petugas' => env('SEED_PETUGAS_PASSWORD', 'petugas123'),
            'donatur' => env('SEED_DONATUR_PASSWORD', 'donatur123'),
        ];

        // Email admin bisa diganti ke email asli (mis. Gmail) lewat .env agar tidak ikut di-commit
        $akun = [
            ['Admin GalangKita',    env('SEED_ADMIN_EMAIL', 'admin@gmail.com'), 'admin'],
            ['Petugas Verifikator', 'petugas@gmail.com',  'petugas'],
            ['Donatur Satu',        'donatur1@gmail.com', 'donatur'],
            ['Donatur Dua',         'donatur2@gmail.com', 'donatur'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make($passwordPerRole[$role])]
            );
            $user->syncRoles($role);

            if ($role === 'donatur') {
                Donatur::updateOrCreate(
                    ['email' => $email],
                    ['user_id' => $user->id, 'nama' => $nama, 'no_telepon' => '081234567890']
                );
            }
        }
    }
}
