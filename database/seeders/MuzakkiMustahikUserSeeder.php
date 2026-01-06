<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Muzakki;
use App\Models\Mustahik;
use Illuminate\Support\Facades\Hash;

class MuzakkiMustahikUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat / update User Muzakki 1
        $muzakkiUser1 = User::updateOrCreate(
            ['email' => 'muzakki1@masjid.com'],
            [
            'username' => 'muzakki1',
            'nama_lengkap' => 'Ahmad Muzakki',
            'name' => 'Ahmad Muzakki',
            'email' => 'muzakki1@masjid.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Raya Masjid No. 1',
            // Gunakan plain text, akan otomatis di-hash oleh cast 'password' => 'hashed'
            'password' => 'password',
            'role' => 'muzakki',
            'status_aktif' => 'aktif',
            'tanggal_daftar' => now(),
        ]);

        $muzakki1 = Muzakki::updateOrCreate(
            ['user_id' => $muzakkiUser1->id],
            [
            'user_id' => $muzakkiUser1->id,
            'nama' => 'Ahmad Muzakki',
            'alamat' => 'Jl. Raya Masjid No. 1',
            'no_hp' => '081234567890',
            'tgl_daftar' => now(),
            'status_pendaftaran' => 'disetujui',
        ]);

        // Buat / update User Muzakki 2
        $muzakkiUser2 = User::updateOrCreate(
            ['email' => 'muzakki2@masjid.com'],
            [
            'username' => 'muzakki2',
            'nama_lengkap' => 'Budi Muzakki',
            'name' => 'Budi Muzakki',
            'email' => 'muzakki2@masjid.com',
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Raya Masjid No. 2',
            'password' => 'password',
            'role' => 'muzakki',
            'status_aktif' => 'aktif',
            'tanggal_daftar' => now(),
        ]);

        $muzakki2 = Muzakki::updateOrCreate(
            ['user_id' => $muzakkiUser2->id],
            [
            'user_id' => $muzakkiUser2->id,
            'nama' => 'Budi Muzakki',
            'alamat' => 'Jl. Raya Masjid No. 2',
            'no_hp' => '081234567891',
            'tgl_daftar' => now(),
            'status_pendaftaran' => 'disetujui',
        ]);

        // Buat / update User Mustahik 1
        $mustahikUser1 = User::updateOrCreate(
            ['email' => 'mustahik1@masjid.com'],
            [
            'username' => 'mustahik1',
            'nama_lengkap' => 'Siti Mustahik',
            'name' => 'Siti Mustahik',
            'email' => 'mustahik1@masjid.com',
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Raya Masjid No. 10',
            'password' => 'password',
            'role' => 'mustahik',
            'status_aktif' => 'aktif',
            'tanggal_daftar' => now(),
        ]);

        $mustahik1 = Mustahik::updateOrCreate(
            ['user_id' => $mustahikUser1->id],
            [
            'user_id' => $mustahikUser1->id,
            'nama' => 'Siti Mustahik',
            'alamat' => 'Jl. Raya Masjid No. 10',
            'kategori_mustahik' => 'Fakir',
            'no_hp' => '081234567892',
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => now(),
        ]);

        // Buat / update User Mustahik 2
        $mustahikUser2 = User::updateOrCreate(
            ['email' => 'mustahik2@masjid.com'],
            [
            'username' => 'mustahik2',
            'nama_lengkap' => 'Rahmat Mustahik',
            'name' => 'Rahmat Mustahik',
            'email' => 'mustahik2@masjid.com',
            'no_hp' => '081234567893',
            'alamat' => 'Jl. Raya Masjid No. 11',
            'password' => 'password',
            'role' => 'mustahik',
            'status_aktif' => 'aktif',
            'tanggal_daftar' => now(),
        ]);

        $mustahik2 = Mustahik::updateOrCreate(
            ['user_id' => $mustahikUser2->id],
            [
            'user_id' => $mustahikUser2->id,
            'nama' => 'Rahmat Mustahik',
            'alamat' => 'Jl. Raya Masjid No. 11',
            'kategori_mustahik' => 'Miskin',
            'no_hp' => '081234567893',
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => now(),
        ]);

        $this->command->info('Berhasil membuat user dan data Muzakki/Mustahik!');
        $this->command->info('Login sebagai Muzakki:');
        $this->command->info('  - Username: muzakki1 / Email: muzakki1@masjid.com / Password: password');
        $this->command->info('  - Username: muzakki2 / Email: muzakki2@masjid.com / Password: password');
        $this->command->info('Login sebagai Mustahik:');
        $this->command->info('  - Username: mustahik1 / Email: mustahik1@masjid.com / Password: password');
        $this->command->info('  - Username: mustahik2 / Email: mustahik2@masjid.com / Password: password');
    }
}

