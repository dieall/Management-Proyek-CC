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
        Schema::create('kurban_dokumentasi', function (Blueprint $table) {
            $table->id('id_dokumentasi');
            $table->unsignedBigInteger('id_riwayat_kurban');
            $table->enum('jenis_dokumentasi', ['penyembelihan', 'pembagian_daging'])->default('penyembelihan');
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_riwayat_kurban')->references('id_riwayat_kurban')->on('riwayat_kurban')->onDelete('cascade');
            $table->index('id_riwayat_kurban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurban_dokumentasi');
    }
};

