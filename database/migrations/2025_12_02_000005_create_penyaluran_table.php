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
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id('id_penyaluran');
            $table->foreignId('id_zis')->constrained('zis_masuk', 'id_zis')->onDelete('cascade');
            $table->date('tgl_salur')->nullable();
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('id_mustahik')->constrained('mustahik', 'id_mustahik')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('id_zis');
            $table->index('id_mustahik');
            $table->index('tgl_salur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};
