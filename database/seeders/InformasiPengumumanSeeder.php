<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InformasiPengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Masjid (Info Masjid)
        DB::table('masjids')->insert([
            'name' => 'Masjid Al-Nassr',
            'address' => 'Jl. Raya Masjid No. 123, Jakarta Selatan',
            'phone' => '021-12345678',
            'email' => 'info@alnassr.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Articles (Pengumuman & Informasi)
        $articles = [
            [
                'title' => 'Jual Beli Sapi Kurban',
                'description' => 'Masjid Al-Nassr membuka pendaftaran jual beli sapi kurban tahun ini dengan harga terjangkau untuk jemaah.',
                'content' => 'Pendaftaran sapi kurban dibuka mulai tanggal 1 Januari hingga 1 Juni. Hubungi DKM untuk informasi lebih lanjut mengenai jenis dan harga sapi kurban.',
                'image_url' => null,
                'link_url' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Gotong Royong di Masjid',
                'description' => 'Kegiatan gotong royong pembersihan masjid akan dilaksanakan pada hari Rabu tanggal 17 Januari 2026.',
                'content' => 'Mari kita bersama-sama menjaga kebersihan dan kenyamanan masjid kita. Acara dimulai pukul 07:00 WIB. Diharapkan seluruh jemaah dapat berpartisipasi.',
                'image_url' => null,
                'link_url' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Kajian Rutin Bulanan',
                'description' => 'Kajian rutin bulanan dengan tema "Akhlak Mulia dalam Kehidupan Sehari-hari" akan dilaksanakan setiap Jumat minggu pertama.',
                'content' => 'Ustadz Ahmad Rifai akan menjadi pembicara pada kajian rutin bulanan kali ini. Semua jemaah dipersilakan hadir. Kajian dimulai pukul 19:30 setelah sholat Isya.',
                'image_url' => null,
                'link_url' => null,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Pembukaan Pendaftaran TPA',
                'description' => 'Pendaftaran siswa baru Taman Pendidikan Al-Quran (TPA) Al-Nassr dibuka untuk tahun ajaran 2026.',
                'content' => 'Pendaftaran dibuka untuk anak usia 5-15 tahun. Pembelajaran Al-Quran, Hadits, Fiqih, dan Akidah Akhlak. Gratis untuk seluruh jemaah. Hubungi Ustadz Hasan untuk pendaftaran.',
                'image_url' => null,
                'link_url' => null,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($articles as $article) {
            DB::table('articles')->insert(array_merge($article, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Seed Weekly Prayer Schedules
        $prayers = [
            [
                'prayer_name' => 'Subuh',
                'monday' => '04:26:00',
                'tuesday' => '04:26:00',
                'wednesday' => '04:27:00',
                'thursday' => '04:27:00',
                'friday' => '04:28:00',
                'saturday' => '04:28:00',
                'sunday' => '04:29:00',
            ],
            [
                'prayer_name' => 'Dzuhur',
                'monday' => '11:45:00',
                'tuesday' => '11:45:00',
                'wednesday' => '11:46:00',
                'thursday' => '11:46:00',
                'friday' => '11:47:00',
                'saturday' => '11:47:00',
                'sunday' => '11:48:00',
            ],
            [
                'prayer_name' => 'Ashar',
                'monday' => '15:12:00',
                'tuesday' => '15:12:00',
                'wednesday' => '15:13:00',
                'thursday' => '15:13:00',
                'friday' => '15:14:00',
                'saturday' => '15:14:00',
                'sunday' => '15:15:00',
            ],
            [
                'prayer_name' => 'Maghrib',
                'monday' => '18:00:00',
                'tuesday' => '18:01:00',
                'wednesday' => '18:01:00',
                'thursday' => '18:02:00',
                'friday' => '18:02:00',
                'saturday' => '18:03:00',
                'sunday' => '18:03:00',
            ],
            [
                'prayer_name' => 'Isya',
                'monday' => '19:03:00',
                'tuesday' => '19:04:00',
                'wednesday' => '19:04:00',
                'thursday' => '19:05:00',
                'friday' => '19:05:00',
                'saturday' => '19:06:00',
                'sunday' => '19:06:00',
            ],
        ];

        foreach ($prayers as $prayer) {
            DB::table('weekly_prayer_schedules')->insert(array_merge($prayer, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Data Informasi & Pengumuman berhasil di-seed!');
        $this->command->info('📰 Total Artikel: 4');
        $this->command->info('🕌 Total Masjid: 1');
        $this->command->info('🕐 Total Jadwal Sholat: 5 waktu');
    }
}
