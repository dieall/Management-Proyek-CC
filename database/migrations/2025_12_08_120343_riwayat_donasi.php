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
        Schema::create('riwayat_donasi', function (Blueprint $table) {
            // PERBAIKAN:
            $table->foreignId('id_jamaah')->constrained('jamaah', 'id_jamaah')->cascadeOnDelete();
            $table->foreignId('id_donasi')->constrained('donasi', 'id_donasi')->cascadeOnDelete();
            
            $table->decimal('besar_donasi', 12, 2);
            $table->date('tanggal_donasi');
            
            $table->primary(['id_jamaah','id_donasi','tanggal_donasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_donasi');
    }
};
