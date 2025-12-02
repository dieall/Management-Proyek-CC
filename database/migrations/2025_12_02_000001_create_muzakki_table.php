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
        Schema::create('muzakki', function (Blueprint $table) {
            $table->id('id_muzakki');
            $table->string('nama', 255);
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('password', 255)->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamps();
            
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muzakki');
    }
};
