<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasjidDataSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Kategori
        $kategoris = [
            ['nama_kategori' => 'Pengurus DKM', 'deskripsi' => 'Kategori khusus untuk Pengurus DKM'],
            ['nama_kategori' => 'Remaja Masjid', 'deskripsi' => 'Kategori khusus untuk Remaja Masjid'],
            ['nama_kategori' => 'Jamaah Tetap', 'deskripsi' => 'Kategori khusus untuk Jamaah Tetap'],
            ['nama_kategori' => 'Donatur Rutin', 'deskripsi' => 'Kategori khusus untuk Donatur Rutin'],
            ['nama_kategori' => 'Musafir', 'deskripsi' => 'Kategori khusus untuk Musafir'],
            ['nama_kategori' => 'Imam Rawatib', 'deskripsi' => 'Kategori khusus untuk Imam Rawatib'],
            ['nama_kategori' => 'Muadzin', 'deskripsi' => 'Kategori khusus untuk Muadzin'],
            ['nama_kategori' => 'Marbot', 'deskripsi' => 'Kategori khusus untuk Marbot'],
            ['nama_kategori' => 'Guru TPA', 'deskripsi' => 'Kategori khusus untuk Guru TPA'],
            ['nama_kategori' => 'Santri TPA', 'deskripsi' => 'Kategori khusus untuk Santri TPA'],
        ];

        foreach ($kategoris as $kategori) {
            DB::table('kategori')->insert([
                'nama_kategori' => $kategori['nama_kategori'],
                'deskripsi' => $kategori['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed Kegiatan
        $kegiatans = [
            ['nama_kegiatan' => 'Kajian Rutin Malam Jum\'at', 'tanggal' => '2026-01-15', 'lokasi' => 'Aula Utama', 'status_kegiatan' => 'aktif', 'deskripsi' => 'Kajian rutin setiap malam Jum\'at'],
            ['nama_kegiatan' => 'Tabligh Akbar Ramadhan', 'tanggal' => '2026-03-10', 'lokasi' => 'Halaman Masjid', 'status_kegiatan' => 'aktif', 'deskripsi' => 'Tabligh akbar menyambut bulan Ramadhan'],
            ['nama_kegiatan' => 'Santunan Anak Yatim', 'tanggal' => '2026-02-20', 'lokasi' => 'Gedung Serbaguna', 'status_kegiatan' => 'aktif', 'deskripsi' => 'Program santunan rutin untuk anak yatim'],
            ['nama_kegiatan' => 'Gotong Royong Masjid', 'tanggal' => '2026-01-25', 'lokasi' => 'Masjid & Lingkungan', 'status_kegiatan' => 'aktif', 'deskripsi' => 'Kegiatan bersih-bersih masjid bersama jamaah'],
            ['nama_kegiatan' => 'Rapat Koordinasi DKM', 'tanggal' => '2026-01-18', 'lokasi' => 'Ruang Rapat', 'status_kegiatan' => 'aktif', 'deskripsi' => 'Rapat evaluasi program bulanan'],
        ];

        foreach ($kegiatans as $kegiatan) {
            DB::table('kegiatan')->insert([
                'nama_kegiatan' => $kegiatan['nama_kegiatan'],
                'tanggal' => $kegiatan['tanggal'],
                'lokasi' => $kegiatan['lokasi'],
                'status_kegiatan' => $kegiatan['status_kegiatan'],
                'deskripsi' => $kegiatan['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed Donasi
        $donasis = [
            ['nama_donasi' => 'Program Renovasi Masjid 2026', 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => '2026-12-31', 'deskripsi' => 'Donasi untuk renovasi dan perbaikan masjid'],
            ['nama_donasi' => 'Beasiswa Santri TPA', 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => '2026-06-30', 'deskripsi' => 'Program beasiswa untuk santri TPA kurang mampu'],
            ['nama_donasi' => 'Bantuan Fakir Miskin', 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => null, 'deskripsi' => 'Program bantuan rutin untuk fakir miskin'],
            ['nama_donasi' => 'Infaq Jumat', 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => null, 'deskripsi' => 'Infaq rutin setiap hari Jumat'],
            ['nama_donasi' => 'Program Takjil Ramadhan 1447H', 'tanggal_mulai' => '2026-03-01', 'tanggal_selesai' => '2026-04-01', 'deskripsi' => 'Donasi untuk program takjil dan buka puasa bersama'],
        ];

        foreach ($donasis as $donasi) {
            DB::table('donasi')->insert([
                'nama_donasi' => $donasi['nama_donasi'],
                'tanggal_mulai' => $donasi['tanggal_mulai'],
                'tanggal_selesai' => $donasi['tanggal_selesai'],
                'deskripsi' => $donasi['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Data Masjid (Kategori, Kegiatan, Donasi) berhasil ditambahkan!');
    }
}

