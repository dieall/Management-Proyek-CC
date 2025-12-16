<?php
// File: database/migrations/YYYY_MM_DD_add_relational_fields_to_muzakki_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('muzakki', function (Blueprint $table) {
            // 1. Tambah Foreign Key ke tabel users
            $table->foreignId('user_id')
                  ->nullable() 
                  ->unique() 
                  ->after('id_muzakki')
                  ->constrained('users')
                  ->onDelete('cascade'); 

            // 2. Tambah status pendaftaran
            $table->enum('status_pendaftaran', ['menunggu', 'disetujui', 'ditolak'])
                  ->default('menunggu')
                  ->after('tgl_daftar');
        });
    }

    public function down(): void
    {
        Schema::table('muzakki', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status_pendaftaran']);
        });
    }
};