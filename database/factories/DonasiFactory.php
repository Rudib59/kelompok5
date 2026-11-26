<?php

namespace Database\Factories;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\Kampanye;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonasiFactory extends Factory
{
    protected $model = Donasi::class;

    public function definition(): array
    {
        return [
            'donatur_id' => Donatur::inRandomOrder()->value('id'),
            'kampanye_id' => Kampanye::inRandomOrder()->value('id'),
            'tanggal_donasi' => fake()->dateTimeBetween('-3 months')->format('Y-m-d'),
            'tanggal_verifikasi' => fake()->optional(0.6)->date(),
            'nominal' => fake()->randomElement([20000, 50000, 100000, 250000, 500000]),
        ];
    }
}
