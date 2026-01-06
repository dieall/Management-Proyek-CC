<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Kurban
        Schema::create('kurban', function (Blueprint $table) {
            $table->id('id_kurban');
            $table->string('nama_kurban');
            $table->date('tanggal_kurban');
            $table->enum('jenis_hewan', ['sapi', 'kambing', 'domba'])->default('sapi');
            $table->integer('target_hewan')->default(1);
            $table->decimal('harga_per_hewan', 15, 2);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });

        // Tabel Riwayat Kurban (Pendaftaran)
        Schema::create('riwayat_kurban', function (Blueprint $table) {
            $table->id('id_riwayat_kurban');
            $table->unsignedBigInteger('id_kurban');
            $table->unsignedBigInteger('id_jamaah');
            $table->enum('jenis_pembayaran', ['penuh', 'patungan'])->default('penuh');
            $table->integer('jumlah_hewan')->default(1);
            $table->decimal('jumlah_pembayaran', 15, 2);
            $table->date('tanggal_pembayaran');
            $table->enum('status_pembayaran', ['lunas', 'cicilan', 'belum_lunas'])->default('belum_lunas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_kurban')->references('id_kurban')->on('kurban')->onDelete('cascade');
            $table->foreign('id_jamaah')->references('id')->on('users')->onDelete('cascade');
            $table->index('id_kurban');
            $table->index('id_jamaah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kurban');
        Schema::dropIfExists('kurban');
    }
};

