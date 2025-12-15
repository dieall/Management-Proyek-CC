<?php

namespace Database\Factories;

use App\Models\Donasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonasiFactory extends Factory
{
    protected $model = Donasi::class;

    public function definition()
    {
        return [
            'nama_donasi' => $this->faker->sentence(2),
            'tanggal_mulai' => $this->faker->date(),
            'tanggal_selesai' => $this->faker->date(),
            'deskripsi' => $this->faker->paragraph()
        ];
    }
}
