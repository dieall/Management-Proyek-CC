<?php

namespace Database\Factories;

use App\Models\Jamaah;
use Illuminate\Database\Eloquent\Factories\Factory;

class JamaahFactory extends Factory
{
    protected $model = Jamaah::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'nama_lengkap' => $this->faker->name(),
            'kata_sandi' => bcrypt('password'),
            'jenis_kelamin' => $this->faker->randomElement(['L','P']),
            'no_handphone' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'tanggal_lahir' => $this->faker->date(),
            'tanggal_bergabung' => now(),
            'status_aktif' => true,
        ];
    }
}
