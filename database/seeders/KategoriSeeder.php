<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Bencana Alam', 'Natural Disaster'],
            ['Lingkungan',   'Environment'],
            ['Kesehatan',    'Health'],
            ['Pendidikan',   'Education'],
            ['Kemanusiaan',  'Humanitarian'],
        ] as [$id, $en]) {
            Kategori::updateOrCreate(['nama' => $id], ['nama_en' => $en]);
        }
    }
}
