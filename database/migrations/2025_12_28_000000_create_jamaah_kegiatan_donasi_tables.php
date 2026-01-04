<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Kategori
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tabel Kategori Jamaah (Many-to-Many)
        Schema::create('kategori_jamaah', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jamaah');
            $table->unsignedBigInteger('id_kategori');
            $table->boolean('status_aktif')->default(true);
            $table->string('periode')->nullable();
            
            $table->primary(['id_jamaah', 'id_kategori']);
            $table->foreign('id_jamaah')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });

        // Tabel Kegiatan
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->string('lokasi')->nullable();
            $table->string('status_kegiatan')->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tabel Keikutsertaan Kegiatan
        Schema::create('keikutsertaan_kegiatan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jamaah');
            $table->unsignedBigInteger('id_kegiatan');
            $table->date('tanggal_daftar')->nullable();
            $table->string('status_kehadiran')->default('belum');
            
            $table->primary(['id_jamaah', 'id_kegiatan']);
            $table->foreign('id_jamaah')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan')->onDelete('cascade');
        });

        // Tabel Donasi
        Schema::create('donasi', function (Blueprint $table) {
            $table->id('id_donasi');
            $table->string('nama_donasi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tabel Riwayat Donasi
        Schema::create('riwayat_donasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jamaah');
            $table->unsignedBigInteger('id_donasi');
            $table->decimal('besar_donasi', 12, 2);
            $table->date('tanggal_donasi');
            
            $table->primary(['id_jamaah', 'id_donasi', 'tanggal_donasi']);
            $table->foreign('id_jamaah')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_donasi')->references('id_donasi')->on('donasi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_donasi');
        Schema::dropIfExists('keikutsertaan_kegiatan');
        Schema::dropIfExists('kategori_jamaah');
        Schema::dropIfExists('donasi');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('kategori');
    }
};

