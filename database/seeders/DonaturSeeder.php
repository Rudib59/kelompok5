<?php

namespace Database\Seeders;

use App\Models\Donatur;
use Illuminate\Database\Seeder;

class DonaturSeeder extends Seeder
{
    public function run(): void
    {
        Donatur::factory()->count(5)->create();
    }
}
