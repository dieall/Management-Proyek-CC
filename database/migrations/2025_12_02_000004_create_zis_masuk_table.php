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
        Schema::create('zis_masuk', function (Blueprint $table) {
            $table->id('id_zis');
            $table->foreignId('id_muzakki')->constrained('muzakki', 'id_muzakki')->onDelete('cascade');
            $table->date('tgl_masuk')->nullable();
            $table->enum('jenis_zis', ['zakat', 'infaq', 'shadaqah', 'wakaf'])->nullable();
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index('id_muzakki');
            $table->index('tgl_masuk');
            $table->index('jenis_zis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zis_masuk');
    }
};
