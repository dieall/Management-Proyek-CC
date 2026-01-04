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
        Schema::create('aset_archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aset_id'); // ID aset yang di-archive
            $table->string('kode_aset');
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak']);
            $table->string('lokasi')->nullable();
            $table->enum('sumber_perolehan', ['pembelian', 'donasi']);
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('vendor')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('nilai_donasi', 15, 2)->nullable();
            $table->string('donatur')->nullable();
            $table->date('tanggal_donasi')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('archived_by')->constrained('users')->onDelete('cascade');
            $table->text('alasan_archive')->nullable();
            $table->timestamp('archived_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_archive');
    }
};
