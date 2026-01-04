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
        // Tabel Masjid
        Schema::create('masjids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // Tabel Artikel/Pengumuman
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Jadwal Sholat Mingguan
        Schema::create('weekly_prayer_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('prayer_name'); // Subuh, Dzuhur, Ashar, Maghrib, Isya
            $table->time('monday');
            $table->time('tuesday');
            $table->time('wednesday');
            $table->time('thursday');
            $table->time('friday');
            $table->time('saturday');
            $table->time('sunday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_prayer_schedules');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('masjids');
    }
};
