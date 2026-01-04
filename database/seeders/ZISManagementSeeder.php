<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ZISManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Muzakki (Pemberi Zakat)
        $muzakkiIds = [];
        
        $muzakkiIds[] = DB::table('muzakki')->insertGetId([
            'nama' => 'Ahmad Ibrahim',
            'alamat' => 'Jl. Raya Bogor No. 123, Jakarta',
            'no_hp' => '081234567890',
            'password' => Hash::make('password123'),
            'status_pendaftaran' => 'disetujui',
            'tgl_daftar' => Carbon::now()->subMonths(6),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $muzakkiIds[] = DB::table('muzakki')->insertGetId([
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Sudirman No. 45, Bandung',
            'no_hp' => '082345678901',
            'password' => Hash::make('password123'),
            'status_pendaftaran' => 'disetujui',
            'tgl_daftar' => Carbon::now()->subMonths(4),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $muzakkiIds[] = DB::table('muzakki')->insertGetId([
            'nama' => 'Muhammad Hasan',
            'alamat' => 'Jl. Gatot Subroto No. 78, Surabaya',
            'no_hp' => '083456789012',
            'password' => Hash::make('password123'),
            'status_pendaftaran' => 'disetujui',
            'tgl_daftar' => Carbon::now()->subMonths(3),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $muzakkiIds[] = DB::table('muzakki')->insertGetId([
            'nama' => 'Fatimah Zahra',
            'alamat' => 'Jl. Ahmad Yani No. 234, Medan',
            'no_hp' => '084567890123',
            'password' => Hash::make('password123'),
            'status_pendaftaran' => 'menunggu',
            'tgl_daftar' => Carbon::now()->subDays(5),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Mustahik (Penerima Zakat)
        $mustahikIds = [];
        
        $mustahikIds[] = DB::table('mustahik')->insertGetId([
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Mawar No. 12, Jakarta Timur',
            'kategori_mustahik' => 'fakir',
            'no_hp' => '085678901234',
            'surat_dtks' => null,
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => Carbon::now()->subMonths(2),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mustahikIds[] = DB::table('mustahik')->insertGetId([
            'nama' => 'Dewi Lestari',
            'alamat' => 'Jl. Melati No. 34, Bandung',
            'kategori_mustahik' => 'miskin',
            'no_hp' => '086789012345',
            'surat_dtks' => null,
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => Carbon::now()->subMonths(3),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mustahikIds[] = DB::table('mustahik')->insertGetId([
            'nama' => 'Hendra Wijaya',
            'alamat' => 'Jl. Cempaka No. 56, Surabaya',
            'kategori_mustahik' => 'gharim',
            'no_hp' => '087890123456',
            'surat_dtks' => null,
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => Carbon::now()->subMonth(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mustahikIds[] = DB::table('mustahik')->insertGetId([
            'nama' => 'Rina Kartika',
            'alamat' => 'Jl. Anggrek No. 78, Medan',
            'kategori_mustahik' => 'ibnu sabil',
            'no_hp' => '088901234567',
            'surat_dtks' => null,
            'status_verifikasi' => 'pending',
            'status' => 'aktif',
            'tgl_daftar' => Carbon::now()->subDays(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mustahikIds[] = DB::table('mustahik')->insertGetId([
            'nama' => 'Yusuf Abdullah',
            'alamat' => 'Jl. Kenanga No. 90, Yogyakarta',
            'kategori_mustahik' => 'fisabillillah',
            'no_hp' => '089012345678',
            'surat_dtks' => null,
            'status_verifikasi' => 'disetujui',
            'status' => 'aktif',
            'tgl_daftar' => Carbon::now()->subWeeks(3),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert ZIS Masuk
        $zisIds = [];
        
        // Zakat Fitrah dari Ahmad Ibrahim
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[0],
            'tgl_masuk' => Carbon::now()->subMonths(2),
            'jenis_zis' => 'zakat',
            'sub_jenis_zis' => 'Zakat Fitrah',
            'jumlah' => 500000,
            'keterangan' => 'Zakat fitrah untuk keluarga (5 orang)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Zakat Mal dari Ahmad Ibrahim
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[0],
            'tgl_masuk' => Carbon::now()->subMonth(),
            'jenis_zis' => 'zakat',
            'sub_jenis_zis' => 'Zakat Mal (Harta)',
            'jumlah' => 5000000,
            'keterangan' => 'Zakat harta tahunan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Infaq dari Siti Aminah
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[1],
            'tgl_masuk' => Carbon::now()->subWeeks(3),
            'jenis_zis' => 'infaq',
            'sub_jenis_zis' => 'Infaq Umum',
            'jumlah' => 2000000,
            'keterangan' => 'Infaq untuk kegiatan masjid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Shadaqah dari Muhammad Hasan
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[2],
            'tgl_masuk' => Carbon::now()->subWeeks(2),
            'jenis_zis' => 'shadaqah',
            'sub_jenis_zis' => 'Shadaqah Jariyah',
            'jumlah' => 1500000,
            'keterangan' => 'Shadaqah untuk pembangunan masjid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Wakaf dari Ahmad Ibrahim
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[0],
            'tgl_masuk' => Carbon::now()->subWeek(),
            'jenis_zis' => 'wakaf',
            'sub_jenis_zis' => 'Wakaf Tunai',
            'jumlah' => 10000000,
            'keterangan' => 'Wakaf untuk tanah masjid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Zakat Fitrah dari Siti Aminah
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[1],
            'tgl_masuk' => Carbon::now()->subDays(5),
            'jenis_zis' => 'zakat',
            'sub_jenis_zis' => 'Zakat Fitrah',
            'jumlah' => 300000,
            'keterangan' => 'Zakat fitrah untuk keluarga (3 orang)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Infaq dari Muhammad Hasan
        $zisIds[] = DB::table('zis_masuk')->insertGetId([
            'id_muzakki' => $muzakkiIds[2],
            'tgl_masuk' => Carbon::now()->subDays(3),
            'jenis_zis' => 'infaq',
            'sub_jenis_zis' => 'Infaq Jumat',
            'jumlah' => 500000,
            'keterangan' => 'Infaq sholat Jumat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Penyaluran
        // Penyaluran dari Zakat Fitrah Ahmad ke Budi (Fakir)
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[0],
            'id_mustahik' => $mustahikIds[0],
            'tgl_salur' => Carbon::now()->subMonths(2)->addDays(3),
            'jumlah' => 200000,
            'keterangan' => 'Bantuan untuk kebutuhan sehari-hari',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penyaluran dari Zakat Fitrah Ahmad ke Dewi (Miskin)
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[0],
            'id_mustahik' => $mustahikIds[1],
            'tgl_salur' => Carbon::now()->subMonths(2)->addDays(3),
            'jumlah' => 200000,
            'keterangan' => 'Bantuan untuk kebutuhan sehari-hari',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penyaluran dari Zakat Mal Ahmad ke Hendra (Gharim)
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[1],
            'id_mustahik' => $mustahikIds[2],
            'tgl_salur' => Carbon::now()->subMonth()->addDays(5),
            'jumlah' => 3000000,
            'keterangan' => 'Bantuan pelunasan hutang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penyaluran dari Infaq Siti ke Yusuf (Fisabillillah)
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[2],
            'id_mustahik' => $mustahikIds[4],
            'tgl_salur' => Carbon::now()->subWeeks(3)->addDays(2),
            'jumlah' => 1500000,
            'keterangan' => 'Bantuan untuk dakwah dan pendidikan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penyaluran dari Shadaqah Muhammad ke Budi
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[3],
            'id_mustahik' => $mustahikIds[0],
            'tgl_salur' => Carbon::now()->subWeeks(2)->addDays(1),
            'jumlah' => 1000000,
            'keterangan' => 'Bantuan renovasi rumah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penyaluran dari Zakat Fitrah Siti ke Dewi
        DB::table('penyaluran')->insert([
            'id_zis' => $zisIds[5],
            'id_mustahik' => $mustahikIds[1],
            'tgl_salur' => Carbon::now()->subDays(5)->addHours(6),
            'jumlah' => 150000,
            'keterangan' => 'Bantuan kebutuhan harian',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Data ZIS Management berhasil di-seed!');
        $this->command->info('📊 Total Muzakki: ' . count($muzakkiIds));
        $this->command->info('📊 Total Mustahik: ' . count($mustahikIds));
        $this->command->info('📊 Total ZIS Masuk: ' . count($zisIds));
        $this->command->info('📊 Total Penyaluran: 6 transaksi');
    }
}
