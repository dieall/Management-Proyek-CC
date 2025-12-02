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
        Schema::create('mustahik', function (Blueprint $table) {
            $table->id('id_mustahik');
            $table->string('nama', 255);
            $table->text('alamat')->nullable();
            $table->string('kategori_mustahik', 50)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('surat_dtks', 255)->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->string('password', 255)->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamps();
            
            $table->index('nama');
            $table->index('kategori_mustahik');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mustahik');
    }
};
