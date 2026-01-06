<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum status_pembayaran dari 'cicilan' menjadi 'verifikasi'
        // Langkah 1: Tambahkan 'verifikasi' ke enum sementara
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN status_pembayaran ENUM('lunas', 'cicilan', 'verifikasi', 'belum_lunas') DEFAULT 'belum_lunas'");
        
        // Langkah 2: Update data lama dari 'cicilan' menjadi 'verifikasi'
        DB::table('riwayat_kurban')
            ->where('status_pembayaran', 'cicilan')
            ->update(['status_pembayaran' => 'verifikasi']);
        
        // Langkah 3: Hapus 'cicilan' dari enum, hanya tersisa 'lunas', 'verifikasi', 'belum_lunas'
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN status_pembayaran ENUM('lunas', 'verifikasi', 'belum_lunas') DEFAULT 'belum_lunas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum lama
        // Langkah 1: Tambahkan 'cicilan' ke enum sementara
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN status_pembayaran ENUM('lunas', 'cicilan', 'verifikasi', 'belum_lunas') DEFAULT 'belum_lunas'");
        
        // Langkah 2: Update data dari 'verifikasi' kembali ke 'cicilan'
        DB::table('riwayat_kurban')
            ->where('status_pembayaran', 'verifikasi')
            ->update(['status_pembayaran' => 'cicilan']);
        
        // Langkah 3: Hapus 'verifikasi' dari enum, kembali ke enum lama
        DB::statement("ALTER TABLE riwayat_kurban MODIFY COLUMN status_pembayaran ENUM('lunas', 'cicilan', 'belum_lunas') DEFAULT 'belum_lunas'");
    }
};

