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
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak'])->default('baik');
            $table->string('lokasi')->nullable();
            $table->enum('sumber_perolehan', ['pembelian', 'donasi'])->default('pembelian');
            $table->decimal('harga', 15, 2)->nullable(); // Hanya admin yang bisa lihat
            $table->string('vendor')->nullable(); // Hanya admin yang bisa lihat
            $table->date('tanggal_pembelian')->nullable(); // Hanya admin yang bisa lihat
            $table->decimal('nilai_donasi', 15, 2)->nullable(); // Untuk donasi, dikonversi ke rupiah
            $table->string('donatur')->nullable(); // Untuk donasi
            $table->date('tanggal_donasi')->nullable(); // Untuk donasi
            $table->string('foto')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
