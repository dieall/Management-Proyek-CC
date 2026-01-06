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
        // Tambah opsi muzakki dan mustahik pada kolom enum role
        // Pastikan semua role yang sudah ada tetap ada: superadmin, admin, dkm, panitia, jemaah, user
        // Tambahkan: muzakki, mustahik
        DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin','admin','dkm','panitia','jemaah','muzakki','mustahik','user') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum sebelumnya (tanpa muzakki dan mustahik)
        DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin','admin','dkm','panitia','jemaah','user') NOT NULL DEFAULT 'user'");
    }
};

