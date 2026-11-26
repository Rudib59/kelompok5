<?php

namespace Database\Seeders;

use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Database\Seeder;

/**
 * Donasi percobaan (Faker) untuk menguji dashboard, laporan, dan IDOR.
 * Tidak dijalankan secara default. Aktifkan dengan SEED_DEMO_DONASI=true di .env.
 */
class DonasiSeeder extends Seeder
{
    public function run(): void
    {
        if (! filter_var(env('SEED_DEMO_DONASI', false), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        Donasi::factory()->count(30)->create();

        Donatur::whereNotNull('user_id')->get()->each(function ($d) {
            Donasi::factory()->count(2)->create(['donatur_id' => $d->id]);
        });
    }
}
