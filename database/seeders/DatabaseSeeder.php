<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            KategoriSeeder::class,
            UserSeeder::class,
            KampanyeSeeder::class,
            DonasiSeeder::class,      // hanya berjalan bila SEED_DEMO_DONASI=true
        ]);
    }
}
