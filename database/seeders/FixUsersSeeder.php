<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua user lama
        DB::table('users')->truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert user baru dengan data yang benar
        $users = [
            [
                'id' => 1,
                'username' => 'admin',
                'nama_lengkap' => 'Administrator Masjid',
                'name' => 'Administrator Masjid',
                'email' => 'admin@masjid.com',
                'no_hp' => '081234567890',
                'alamat' => 'Masjid Al-Nassr',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'username' => 'dkm',
                'nama_lengkap' => 'Ketua DKM',
                'name' => 'Ketua DKM',
                'email' => 'dkm@masjid.com',
                'no_hp' => '081234567891',
                'alamat' => 'Masjid Al-Nassr',
                'password' => Hash::make('dkm123'),
                'role' => 'dkm',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'username' => 'Hasan',
                'nama_lengkap' => 'Zulkipli Hasan',
                'name' => 'Zulkipli Hasan',
                'email' => 'panitia@masjid.com',
                'no_hp' => '081234567893',
                'alamat' => 'Masjid Al-Nassr',
                'password' => Hash::make('panitia123'),
                'role' => 'panitia',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'username' => 'panitia2',
                'nama_lengkap' => 'Siti Nur Aliyah',
                'name' => 'Siti Nur Aliyah',
                'email' => 'panitia2@masjid.com',
                'no_hp' => '081234567894',
                'alamat' => 'Masjid Al-Nassr',
                'password' => Hash::make('panitia123'),
                'role' => 'panitia',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'username' => 'jamaah',
                'nama_lengkap' => 'Ahmad Yusuf',
                'name' => 'Ahmad Yusuf',
                'email' => 'jamaah@masjid.com',
                'no_hp' => '081234567895',
                'alamat' => 'Jl. Contoh No. 123',
                'password' => Hash::make('jamaah123'),
                'role' => 'jemaah',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'username' => 'budi',
                'nama_lengkap' => 'Budi Santoso',
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'no_hp' => '081234567896',
                'alamat' => 'Jl. Melati No. 45',
                'password' => Hash::make('password'),
                'role' => 'jemaah',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'username' => 'siti',
                'nama_lengkap' => 'Siti Aminah',
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'no_hp' => '081234567897',
                'alamat' => 'Jl. Mawar No. 12',
                'password' => Hash::make('password'),
                'role' => 'jemaah',
                'status_aktif' => 'aktif',
                'tanggal_daftar' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        $this->command->info('✅ Users berhasil diperbaiki!');
        $this->command->info('');
        $this->command->info('Akun yang tersedia:');
        $this->command->info('1. Admin     - username: admin    - password: admin123');
        $this->command->info('2. DKM       - username: dkm      - password: dkm123');
        $this->command->info('3. Panitia   - username: Hasan    - password: panitia123');
        $this->command->info('4. Panitia 2 - username: panitia2 - password: panitia123');
        $this->command->info('5. Jemaah    - username: jamaah   - password: jamaah123');
        $this->command->info('6. Jemaah 2  - username: budi     - password: password');
        $this->command->info('7. Jemaah 3  - username: siti     - password: password');
    }
}

