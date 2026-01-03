<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained('votings')->cascadeOnDelete();
            $table->foreignId('committee_id')->constrained('committees')->cascadeOnDelete();
            $table->enum('vote', ['yes', 'no']);
            $table->text('comment')->nullable();
            $table->timestamps();

            // Satu orang hanya boleh vote sekali per voting
            $table->unique(['voting_id', 'committee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
