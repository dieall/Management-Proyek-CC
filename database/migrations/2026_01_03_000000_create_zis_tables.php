<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Muzakki (Pemberi Zakat)
        Schema::create('muzakki', function (Blueprint $table) {
            $table->id('id_muzakki');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('password')->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->enum('status_pendaftaran', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('nama');
        });

        // Tabel Mustahik (Penerima Zakat)
        Schema::create('mustahik', function (Blueprint $table) {
            $table->id('id_mustahik');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('kategori_mustahik', 50)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('disetujui');
            $table->string('surat_dtks')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->string('password')->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamps();
            
            $table->index('nama');
            $table->index('kategori_mustahik');
            $table->index('status');
        });

        // Tabel Petugas ZIS
        Schema::create('petugas_zis', function (Blueprint $table) {
            $table->id('id_petugas_zis');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('password')->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->index('nama');
        });

        // Tabel ZIS Masuk
        Schema::create('zis_masuk', function (Blueprint $table) {
            $table->id('id_zis');
            $table->unsignedBigInteger('id_muzakki');
            $table->date('tgl_masuk')->nullable();
            $table->enum('jenis_zis', ['zakat', 'infaq', 'shadaqah', 'wakaf'])->nullable();
            $table->string('sub_jenis_zis', 50)->nullable();
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_muzakki')->references('id_muzakki')->on('muzakki')->onDelete('cascade');
            $table->index('tgl_masuk');
            $table->index('jenis_zis');
        });

        // Tabel Penyaluran
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id('id_penyaluran');
            $table->unsignedBigInteger('id_zis');
            $table->date('tgl_salur')->nullable();
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_mustahik');
            $table->timestamps();
            
            $table->foreign('id_zis')->references('id_zis')->on('zis_masuk')->onDelete('cascade');
            $table->foreign('id_mustahik')->references('id_mustahik')->on('mustahik')->onDelete('cascade');
            $table->index('tgl_salur');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
        Schema::dropIfExists('zis_masuk');
        Schema::dropIfExists('petugas_zis');
        Schema::dropIfExists('mustahik');
        Schema::dropIfExists('muzakki');
    }
};










