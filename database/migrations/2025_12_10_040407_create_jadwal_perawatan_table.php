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
        Schema::create('jadwal_perawatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id')->constrained('aset')->onDelete('cascade');
            $table->string('jenis_perawatan'); // rutin, berkala, darurat
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_jadwal');
            $table->enum('status', ['terjadwal', 'sedang_dilakukan', 'selesai', 'dibatalkan'])->default('terjadwal');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_perawatan');
    }
};
