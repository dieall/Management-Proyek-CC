<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\PetugasZis;
use App\Models\ZisMasuk;
use App\Models\Penyaluran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (Petugas ZIS)
        $adminUser = User::factory()->admin()->create([
            'username' => 'admin_zis',
            'nama_lengkap' => 'Admin ZIS',
            'email' => 'admin@zis.local',
            'no_hp' => '081234567890',
        ]);

        // Create PetugasZis
        $petugas = PetugasZis::factory()->create([
            'nama' => 'Admin ZIS',
            'id_user' => $adminUser->id,
        ]);

        // Create other users
        User::factory(5)->create();

        // Create Muzakki (Zakat Payers)
        Muzakki::factory(10)->create();

        // Create Mustahik (Zakat Recipients)
        Mustahik::factory(15)->create();

        // Create ZIS Masuk (incoming zakat/infak/sedekah)
        ZisMasuk::factory(20)->create();

        // Create Penyaluran (distribution)
        Penyaluran::factory(15)->create();
    }
}
