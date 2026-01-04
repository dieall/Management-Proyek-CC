<?php

namespace Database\Seeders;

use App\Models\Committee;
use App\Models\JobResponsibility;
use App\Models\Position;
use App\Models\TaskAssignment;
use App\Models\DutySchedule;
use App\Models\OrganizationalStructure;
use App\Models\Voting;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TakmirSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Clear minimal tables to avoid duplicates when re-running
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Vote::truncate();
        Voting::truncate();
        OrganizationalStructure::truncate();
        TaskAssignment::truncate();
        DutySchedule::truncate();
        JobResponsibility::truncate();
        Committee::truncate();
        Position::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Positions (hierarchy)
        $chair = Position::create([
            'name' => 'Ketua',
            'slug' => Str::slug('Ketua'),
            'description' => 'Ketua pengurus masjid',
            'order' => 1,
            'status' => 'active',
            'level' => 'leadership',
        ]);

        $vice = Position::create([
            'name' => 'Wakil Ketua',
            'slug' => Str::slug('Wakil Ketua'),
            'description' => 'Wakil Ketua pengurus',
            'parent_id' => $chair->id,
            'order' => 2,
            'status' => 'active',
            'level' => 'leadership',
        ]);

        $treasurer = Position::create([
            'name' => 'Bendahara',
            'slug' => Str::slug('Bendahara'),
            'description' => 'Mengelola keuangan',
            'parent_id' => $chair->id,
            'order' => 3,
            'status' => 'active',
            'level' => 'staff',
        ]);

        $imam = Position::create([
            'name' => 'Imam',
            'slug' => Str::slug('Imam'),
            'description' => 'Pemimpin shalat',
            'order' => 10,
            'status' => 'active',
            'level' => 'member',
        ]);

        // 2. Committees (pengurus)
        $committee1 = Committee::create([
            'full_name' => 'Ahmad Hidayat',
            'email' => 'ahmad.hidayat@example.com',
            'phone_number' => '081234567890',
            'gender' => 'male',
            'address' => 'Jl. Merdeka No.1',
            'birth_date' => '1980-05-15',
            'join_date' => '2024-01-01',
            'active_status' => 'active',
            'position_id' => $chair->id,
            'photo_path' => 'committees/ahmad.jpg',
            'cv_path' => 'committees/ahmad_cv.pdf',
        ]);

        $committee2 = Committee::create([
            'full_name' => 'Siti Nurhaliza',
            'email' => 'siti.n@example.com',
            'phone_number' => '081298765432',
            'gender' => 'female',
            'address' => 'Jl. Melati No.2',
            'birth_date' => '1985-09-02',
            'join_date' => '2024-03-01',
            'active_status' => 'active',
            'position_id' => $treasurer->id,
            'photo_path' => 'committees/siti.jpg',
            'cv_path' => 'committees/siti_cv.pdf',
        ]);

        $committee3 = Committee::create([
            'full_name' => 'Ust. Hendra',
            'email' => 'hendra@example.com',
            'phone_number' => '081377788899',
            'gender' => 'male',
            'address' => 'Jl. Kebon No.3',
            'birth_date' => '1975-12-12',
            'join_date' => '2022-06-15',
            'active_status' => 'active',
            'position_id' => $imam->id,
            'photo_path' => 'committees/hendra.jpg',
            'cv_path' => 'committees/hendra_cv.pdf',
        ]);

        // 3. Job responsibilities
        $jr1 = JobResponsibility::create([
            'position_id' => $chair->id,
            'task_name' => 'Memimpin rapat pengurus',
            'task_description' => 'Mengkoordinasikan rapat bulanan pengurus',
            'priority' => 'high',
            'estimated_hours' => 4,
            'frequency' => 'monthly',
            'is_core_responsibility' => true,
        ]);

        $jr2 = JobResponsibility::create([
            'position_id' => $treasurer->id,
            'task_name' => 'Mengelola kas',
            'task_description' => 'Mencatat pemasukan dan pengeluaran',
            'priority' => 'critical',
            'estimated_hours' => 8,
            'frequency' => 'weekly',
            'is_core_responsibility' => true,
        ]);

        $jr3 = JobResponsibility::create([
            'position_id' => $imam->id,
            'task_name' => 'Memimpin shalat',
            'task_description' => 'Menjadi imam pada shalat berjamaah',
            'priority' => 'medium',
            'frequency' => 'daily',
            'is_core_responsibility' => true,
        ]);

        // 4. Duty Schedules (recurring)
        DutySchedule::create([
            'committee_id' => $committee3->id,
            'duty_date' => Carbon::now()->addDays(1)->toDateString(),
            'start_time' => '05:00:00',
            'end_time' => '06:00:00',
            'location' => 'Masjid Utama',
            'duty_type' => 'piket',
            'status' => 'scheduled',
            'is_recurring' => true,
            'recurring_type' => 'daily',
            'recurring_end_date' => Carbon::now()->addMonths(6)->toDateString(),
        ]);

        DutySchedule::create([
            'committee_id' => $committee2->id,
            'duty_date' => Carbon::now()->addDays(2)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
            'location' => 'Halaman Masjid',
            'duty_type' => 'kebersihan',
            'status' => 'scheduled',
            'is_recurring' => false,
        ]);

        // 5. Task assignments
        TaskAssignment::create([
            'committee_id' => $committee2->id,
            'job_responsibility_id' => $jr2->id,
            'assigned_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addWeek()->toDateString(),
            'status' => 'in_progress',
            'progress_percentage' => 20,
            'notes' => 'Mulai menata buku kas',
        ]);

        TaskAssignment::create([
            'committee_id' => $committee1->id,
            'job_responsibility_id' => $jr1->id,
            'assigned_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addWeeks(2)->toDateString(),
            'status' => 'pending',
            'progress_percentage' => 0,
            'notes' => 'Siapkan agenda rapat bulan depan',
        ]);

        // 6. Organizational Structure (simple nesting)
        $root = OrganizationalStructure::create([
            'position_id' => $chair->id,
            'parent_id' => null,
            'lft' => 1,
            'rgt' => 6,
            'depth' => 0,
            'order' => 1,
            'is_division' => false,
        ]);

        OrganizationalStructure::create([
            'position_id' => $treasurer->id,
            'parent_id' => $root->id,
            'lft' => 2,
            'rgt' => 3,
            'depth' => 1,
            'order' => 1,
        ]);

        OrganizationalStructure::create([
            'position_id' => $imam->id,
            'parent_id' => $root->id,
            'lft' => 4,
            'rgt' => 5,
            'depth' => 1,
            'order' => 2,
        ]);

        // 7. Voting and Votes
        $voting = Voting::create([
            'committee_id' => $committee1->id,
            'position_id' => $treasurer->id,
            'start_date' => Carbon::now()->subDays(1)->toDateTimeString(),
            'end_date' => Carbon::now()->addDays(6)->toDateTimeString(),
            'status' => 'open',
            'description' => 'Pemilihan Bendahara periode 2026-2027',
        ]);

        Vote::create([
            'voting_id' => $voting->id,
            'committee_id' => $committee2->id,
            'vote' => 'yes',
            'comment' => 'Setuju calon terpilih karena rekam jejak baik',
        ]);

        Vote::create([
            'voting_id' => $voting->id,
            'committee_id' => $committee3->id,
            'vote' => 'yes',
            'comment' => 'Mendukung',
        ]);
    }
}
