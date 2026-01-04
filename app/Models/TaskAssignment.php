<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'committee_id',
        'job_responsibility_id',
        'assigned_date',
        'due_date',
        'status',
        'progress_percentage',
        'notes',
        'completed_date',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'due_date' => 'date',
        'completed_date' => 'date',
        'progress_percentage' => 'integer',
        'approved_at' => 'datetime',
    ];

    // Relasi ke Committee
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    // Relasi ke Job Responsibility
    public function jobResponsibility()
    {
        return $this->belongsTo(JobResponsibility::class);
    }

    // Relasi ke Committee (Approver)
    public function approver()
    {
        return $this->belongsTo(Committee::class, 'approved_by');
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    // Helper method untuk cek apakah overdue
    public function isOverdue()
    {
        return $this->status !== 'completed' && $this->due_date < now()->toDateString();
    }
}

