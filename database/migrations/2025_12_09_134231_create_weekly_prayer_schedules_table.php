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
        Schema::create('weekly_prayer_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('prayer_name');
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
    }
};
