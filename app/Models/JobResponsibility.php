<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobResponsibility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'position_id',
        'task_name',
        'task_description',
        'priority',
        'estimated_hours',
        'frequency',
        'is_core_responsibility',
    ];

    protected $casts = [
        'estimated_hours' => 'integer',
        'is_core_responsibility' => 'boolean',
    ];

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relasi ke Task Assignments
    public function taskAssignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    // Scope untuk core responsibility
    public function scopeCore($query)
    {
        return $query->where('is_core_responsibility', true);
    }

    // Scope untuk priority
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}











