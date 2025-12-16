<?php
// File: database/migrations/YYYY_MM_DD_add_sub_jenis_zis_to_zis_masuk_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zis_masuk', function (Blueprint $table) {
            $table->string('sub_jenis_zis', 50)->nullable()->after('jenis_zis');
        });
    }

    public function down(): void
    {
        Schema::table('zis_masuk', function (Blueprint $table) {
            $table->dropColumn('sub_jenis_zis');
        });
    }
};