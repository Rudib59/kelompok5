<?php

namespace Database\Factories;

use App\Models\Donatur;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonaturFactory extends Factory
{
    protected $model = Donatur::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'no_telepon' => fake()->numerify('08##########'),
        ];
    }
}
