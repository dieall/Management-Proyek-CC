<?php

// File: database/migrations/..._add_status_verifikasi_to_mustahik_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            // Tambahkan kolom status_verifikasi
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])
                  ->default('disetujui') // Default 'disetujui' untuk data lama yang valid
                  ->after('no_hp'); // Posisikan setelah kolom 'no_hp' (opsional)
        });
    }

    public function down(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};