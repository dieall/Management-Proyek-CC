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
        Schema::create('laporan_perawatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_perawatan_id')->constrained('jadwal_perawatan')->onDelete('cascade');
            $table->foreignId('aset_id')->constrained('aset')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengurus yang mengisi
            $table->date('tanggal_pemeriksaan');
            $table->enum('kondisi_sebelum', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak']);
            $table->enum('kondisi_sesudah', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak']);
            $table->text('hasil_pemeriksaan');
            $table->text('tindakan')->nullable();
            $table->decimal('biaya_perawatan', 15, 2)->nullable();
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perawatan');
    }
};
