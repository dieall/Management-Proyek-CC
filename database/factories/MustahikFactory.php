<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mustahik>
 */
class MustahikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['fakir', 'miskin', 'amil', 'muallaf', 'riqab', 'gharim', 'fisabillillah', 'ibnu sabil'];
        
        return [
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'kategori_mustahik' => fake()->randomElement($categories),
            'no_hp' => fake()->phoneNumber(),
            'surat_dtks' => null,
            'status' => 'aktif',
            'password' => Hash::make('password'),
            'tgl_daftar' => now(),
        ];
    }
}
