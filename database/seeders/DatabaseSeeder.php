<?php

namespace Database\Seeders;

// Import Model
use App\Models\Jamaah;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donasi;
use App\Models\RiwayatDonasi;
use App\Models\KeikutsertaanKegiatan;
use App\Models\KategoriJamaah; 
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ====================================================
        // 1. SEED KATEGORI (20 Data)
        // ====================================================
        $kategoriList = [
            'Pengurus DKM', 'Remaja Masjid', 'Jamaah Tetap', 'Donatur Rutin', 'Musafir',
            'Imam Rawatib', 'Muadzin', 'Marbot', 'Guru TPA', 'Santri TPA',
            'Panitia Qurban', 'Panitia Ramadhan', 'Seksi Kebersihan', 'Seksi Keamanan', 'Seksi Peralatan',
            'Seksi Konsumsi', 'Jamaah Akhwat', 'Jamaah Ikhwan', 'Donatur Insidental', 'Simpatisan'
        ];

        $kategoriIds = [];
        foreach ($kategoriList as $kat) {
            $data = Kategori::create([
                'nama_kategori' => $kat,
                'deskripsi' => 'Kategori khusus untuk ' . $kat
            ]);
            $kategoriIds[] = $data->id_kategori;
        }

        // ====================================================
        // 2. SEED JAMAAH (20 Data + 1 Admin)
        // ====================================================
        
        // A. Akun Admin Utama
        $admin = Jamaah::create([
            'username' => 'admin',
            'nama_lengkap' => 'Arya Eka Septiaputra',
            'kata_sandi' => 'password', 
            'jenis_kelamin' => 'L',
            'no_handphone' => '081234567890',
            'alamat' => 'Jl. Masjid No. 1, Bandung',
            'tanggal_lahir' => '1995-05-20',
            'tanggal_bergabung' => now(),
            'status_aktif' => true,
        ]);

        KategoriJamaah::create([
            'id_jamaah' => $admin->id_jamaah,
            'id_kategori' => $kategoriIds[0], 
            'status_aktif' => true,
            'periode' => '2025-2030'
        ]);

        $jamaahIds = [$admin->id_jamaah];

        // B. Buat 20 Jamaah Dummy
        for ($i = 1; $i <= 20; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $newUser = Jamaah::create([
                'username' => 'user' . $i,
                'nama_lengkap' => $faker->name($gender == 'L' ? 'male' : 'female'),
                'kata_sandi' => 'password',
                'jenis_kelamin' => $gender,
                'no_handphone' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'tanggal_bergabung' => $faker->dateTimeBetween('-2 years', 'now'),
                'status_aktif' => true,
            ]);
            $jamaahIds[] = $newUser->id_jamaah;

            $randomCats = $faker->randomElements($kategoriIds, rand(1, 2));
            foreach ($randomCats as $catId) {
                KategoriJamaah::create([
                    'id_jamaah' => $newUser->id_jamaah,
                    'id_kategori' => $catId,
                    'status_aktif' => true,
                    'periode' => '2025'
                ]);
            }
        }

        // ====================================================
        // 3. SEED KEGIATAN (20 Data)
        // ====================================================
        $kegiatanIds = [];
        $jenisKegiatan = ['Kajian', 'Gotong Royong', 'Rapat', 'Santunan', 'Tabligh Akbar'];
        
        for ($i = 1; $i <= 20; $i++) {
            $kegiatan = Kegiatan::create([
                'nama_kegiatan' => $faker->randomElement($jenisKegiatan) . ' ' . $faker->words(2, true),
                'tanggal' => $faker->dateTimeBetween('-1 month', '+3 months'),
                'lokasi' => $faker->randomElement(['Aula Utama', 'Halaman Masjid', 'Ruang Rapat', 'Gedung Serbaguna']),
                'status_kegiatan' => $faker->randomElement(['aktif', 'selesai', 'batal']),
                'deskripsi' => $faker->paragraph(1)
            ]);
            $kegiatanIds[] = $kegiatan->id_kegiatan;
        }

        // ====================================================
        // 4. SEED KEIKUTSERTAAN KEGIATAN (FIX DUPLICATE)
        // ====================================================
        // LOGIKA BARU: Loop per Jamaah, pilihkan kegiatan unik untuk mereka
        
        foreach ($jamaahIds as $jId) {
            // Setiap jamaah mengikuti antara 0 sampai 4 kegiatan secara acak
            // randomElements memastikan ID kegiatan UNIK, jadi tidak akan error duplicate
            $kegiatanYangDiikuti = $faker->randomElements($kegiatanIds, rand(0, 4));

            foreach ($kegiatanYangDiikuti as $kId) {
                KeikutsertaanKegiatan::create([
                    'id_jamaah' => $jId,
                    'id_kegiatan' => $kId,
                    'tanggal_daftar' => $faker->dateTimeBetween('-1 month', 'now'),
                    'status_kehadiran' => $faker->randomElement(['hadir', 'izin', 'alpa', 'terdaftar'])
                ]);
            }
        }

        // ====================================================
        // 5. SEED DONASI / PROGRAM (20 Data)
        // ====================================================
        $donasiIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $donasi = Donasi::create([
                'nama_donasi' => 'Program ' . $faker->words(3, true),
                'deskripsi' => $faker->sentence(),
                'tanggal_mulai' => $faker->dateTimeBetween('-1 year', 'now'),
                'tanggal_selesai' => $faker->dateTimeBetween('now', '+1 year'),
            ]);
            $donasiIds[] = $donasi->id_donasi;
        }

        // ====================================================
        // 6. SEED RIWAYAT DONASI / TRANSAKSI (50 Data)
        // ====================================================
        // ====================================================
        // 6. SEED RIWAYAT DONASI / TRANSAKSI (50 Data)
        // ====================================================
        for ($i = 0; $i < 50; $i++) {
            RiwayatDonasi::create([
                'id_jamaah' => $faker->randomElement($jamaahIds),
                'id_donasi' => $faker->randomElement($donasiIds),
                'besar_donasi' => $faker->randomElement([10000, 20000, 50000, 100000, 500000, 1000000, 2500000]),
                'tanggal_donasi' => $faker->dateTimeBetween('-6 months', 'now'),
                // 'status' => 'berhasil'  <-- HAPUS ATAU KOMENTARI BARIS INI
            ]);
        }
    }
}