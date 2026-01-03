<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('zis_masuk', function (Blueprint $table) {
            $table->string('jenis_zis', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zis_masuk', function (Blueprint $table) {
            $table->enum('jenis_zis', ['zakat', 'infaq', 'shadaqah', 'wakaf'])->change();
        });
    }
};
