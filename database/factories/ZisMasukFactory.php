<?php

namespace Database\Factories;

use App\Models\Muzakki;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZisMasuk>
 */
class ZisMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = ['zakat', 'infaq', 'shadaqah', 'wakaf'];
        
        return [
            'id_muzakki' => Muzakki::factory(),
            'tgl_masuk' => fake()->dateTimeBetween('-3 months', 'now'),
            'jenis_zis' => fake()->randomElement($jenis),
            'jumlah' => fake()->numberBetween(50000, 5000000),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
