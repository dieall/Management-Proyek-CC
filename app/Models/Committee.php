<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'gender',
        'address',
        'birth_date',
        'join_date',
        'active_status',
        'position_id',
        'user_id',
        'photo_path',
        'cv_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relasi ke Position Histories
    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class)->orderBy('start_date', 'desc');
    }

    // Relasi ke Duty Schedules
    public function dutySchedules()
    {
        return $this->hasMany(DutySchedule::class);
    }

    // Relasi ke Task Assignments
    public function taskAssignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    // Relasi ke Votings (sebagai kandidat)
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    // Relasi ke Votes (sebagai pemberi suara)
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Relasi ke Task Assignments (sebagai approver)
    public function approvedTasks()
    {
        return $this->hasMany(TaskAssignment::class, 'approved_by');
    }

    // Scope untuk status aktif
    public function scopeActive($query)
    {
        return $query->where('active_status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('active_status', 'inactive');
    }

    public function scopeResigned($query)
    {
        return $query->where('active_status', 'resigned');
    }
}







