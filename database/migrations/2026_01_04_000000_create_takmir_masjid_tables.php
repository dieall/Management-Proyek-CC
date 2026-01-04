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
        // Table: positions
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('level', ['leadership', 'member', 'staff'])->default('member');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('positions')->onDelete('set null');
            $table->index(['parent_id', 'status']);
        });

        // Table: committees
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('active_status', ['active', 'inactive', 'resigned'])->default('active');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('user_id')->unique()->nullable();
            $table->string('photo_path', 500)->nullable();
            $table->string('cv_path', 500)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('position_id');
            $table->index('active_status');
            $table->index('user_id');
        });

        // Table: position_histories
        Schema::create('position_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id');
            $table->unsignedBigInteger('position_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('appointment_type', ['election', 'appointment', 'volunteer'])->default('appointment');
            $table->text('remarks')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->index('is_active');
            $table->index('committee_id');
            $table->index('position_id');
        });

        // Table: job_responsibilities
        Schema::create('job_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->integer('estimated_hours')->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'on_demand'])->default('on_demand');
            $table->boolean('is_core_responsibility')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->index('position_id');
        });

        // Table: duty_schedules
        Schema::create('duty_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id');
            $table->date('duty_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->enum('duty_type', ['piket', 'kebersihan', 'keamanan', 'acara', 'lainnya'])->default('piket');
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->text('remarks')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->date('recurring_end_date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->index('duty_date');
            $table->index('committee_id');
            $table->index('duty_type');
        });

        // Table: task_assignments
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id');
            $table->unsignedBigInteger('job_responsibility_id');
            $table->date('assigned_date')->nullable();
            $table->date('due_date');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled', 'overdue'])->default('pending');
            $table->integer('progress_percentage')->default(0);
            $table->text('notes')->nullable();
            $table->date('completed_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->foreign('job_responsibility_id')->references('id')->on('job_responsibilities')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('committees')->onDelete('set null');
            $table->index('status');
            $table->index('due_date');
            $table->index('committee_id');
            $table->index('job_responsibility_id');
            
        });

        // Table: organizational_structures
        Schema::create('organizational_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('depth')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_division')->default(false);
            $table->string('division_name')->nullable();
            $table->text('division_description')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('organizational_structures')->onDelete('cascade');
            $table->unique('position_id');
            $table->index('parent_id');
            $table->index(['lft', 'rgt']);
        });

        // Table: votings
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id');
            $table->unsignedBigInteger('position_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['open', 'closed', 'approved', 'rejected'])->default('open');
            $table->text('description')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->index('status');
            $table->index('committee_id');
            $table->index(['start_date', 'end_date']);
        });

        // Table: votes
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voting_id');
            $table->unsignedBigInteger('committee_id');
            $table->enum('vote', ['yes', 'no']);
            $table->text('comment')->nullable();
            $table->timestamps();
            
            $table->foreign('voting_id')->references('id')->on('votings')->onDelete('cascade');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->unique(['voting_id', 'committee_id']);
            $table->index('voting_id');
            $table->index('committee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
        Schema::dropIfExists('votings');
        Schema::dropIfExists('organizational_structures');
        Schema::dropIfExists('task_assignments');
        Schema::dropIfExists('duty_schedules');
        Schema::dropIfExists('job_responsibilities');
        Schema::dropIfExists('position_histories');
        Schema::dropIfExists('committees');
        Schema::dropIfExists('positions');
    }
};

