<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $semua = [
            'akses-dashboard-admin',
            'akses-dashboard-petugas',
            'akses-dashboard-penggalang-dana',
            'lihat-daftar-kampanye',
            'kelola-data-kampanye',
            'kelola-pengguna',
            'kelola-role',
            'kelola-donasi',
            'kelola-verifikasi-pembayaran',
            'mengajukan-donasi',
            'memproses-persetujuan-donasi',
            'mencatat-verifikasi-pembayaran',
            'melihat-status-donasi-sendiri',
            'lihat-riwayat-donasi-sendiri',
            'lihat-laporan',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
            'mengajukan-permohonan-penggalang-dana',
            'kelola-pengajuan-penggalang-dana',
            'mengajukan-kampanye',
            'kelola-kampanye-sendiri',
            'lihat-donasi-kampanye-sendiri',
            'mengajukan-pencairan-dana',
            'buat-update-kampanye',
        ];

        foreach ($semua as $p) {
            Permission::findOrCreate($p, 'web');
        }

        $umum = [
            'lihat-daftar-kampanye',
            'mengajukan-donasi',
            'melihat-status-donasi-sendiri',
            'lihat-riwayat-donasi-sendiri',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ];

        $operasional = [
            'kelola-data-kampanye',
            'kelola-donasi',
            'kelola-verifikasi-pembayaran',
            'memproses-persetujuan-donasi',
            'mencatat-verifikasi-pembayaran',
            'lihat-laporan',
        ];

        Role::findOrCreate('admin', 'web')->syncPermissions(array_merge(
            $umum,
            $operasional,
            [
                'akses-dashboard-admin',
                'kelola-pengguna',
                'kelola-role',
                'kelola-pengajuan-penggalang-dana',
            ]
        ));

        Role::findOrCreate('petugas', 'web')->syncPermissions(array_merge(
            $umum,
            $operasional,
            ['akses-dashboard-petugas']
        ));

        Role::findOrCreate('donatur', 'web')->syncPermissions(array_merge(
            $umum,
            ['mengajukan-permohonan-penggalang-dana']
        ));

        Role::findOrCreate('penggalang_dana', 'web')->syncPermissions(array_merge(
            $umum,
            [
                'akses-dashboard-penggalang-dana',
                'mengajukan-kampanye',
                'kelola-kampanye-sendiri',
                'lihat-donasi-kampanye-sendiri',
                'mengajukan-pencairan-dana',
                'buat-update-kampanye',
            ]
        ));
    }
}
