<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah opsi superadmin pada kolom enum role
        DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin','admin','user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // Kembalikan ke enum sebelumnya
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user') NOT NULL DEFAULT 'user'");
    }
};





















