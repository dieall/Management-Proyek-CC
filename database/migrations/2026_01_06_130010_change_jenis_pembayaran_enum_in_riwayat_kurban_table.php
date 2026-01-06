<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Izinkan dulu semua nilai lama & baru di enum
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN jenis_pembayaran ENUM('penuh', 'patungan', 'transfer', 'tunai') DEFAULT 'transfer'");

        // 2. Konversi data lama ke skema baru
        //    penuh    -> transfer
        //    patungan -> tunai
        DB::table('riwayat_kurban')
            ->where('jenis_pembayaran', 'penuh')
            ->update(['jenis_pembayaran' => 'transfer']);

        DB::table('riwayat_kurban')
            ->where('jenis_pembayaran', 'patungan')
            ->update(['jenis_pembayaran' => 'tunai']);

        // 3. Baru perketat enum hanya ke nilai baru saja
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN jenis_pembayaran ENUM('transfer', 'tunai') DEFAULT 'transfer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Izinkan semua nilai lama & baru
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN jenis_pembayaran ENUM('penuh', 'patungan', 'transfer', 'tunai') DEFAULT 'transfer'");

        // 2. Konversi kembali ke skema lama
        DB::table('riwayat_kurban')
            ->where('jenis_pembayaran', 'transfer')
            ->update(['jenis_pembayaran' => 'penuh']);

        DB::table('riwayat_kurban')
            ->where('jenis_pembayaran', 'tunai')
            ->update(['jenis_pembayaran' => 'patungan']);

        // 3. Perketat enum hanya ke nilai lama
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN jenis_pembayaran ENUM('penuh', 'patungan') DEFAULT 'penuh'");
    }
};

