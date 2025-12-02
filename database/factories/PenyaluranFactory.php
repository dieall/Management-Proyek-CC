<?php

namespace Database\Factories;

use App\Models\Mustahik;
use App\Models\ZisMasuk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penyaluran>
 */
class PenyaluranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_zis' => ZisMasuk::factory(),
            'id_mustahik' => Mustahik::factory(),
            'tgl_salur' => fake()->dateTimeBetween('-1 month', 'now'),
            'jumlah' => fake()->numberBetween(50000, 2000000),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
