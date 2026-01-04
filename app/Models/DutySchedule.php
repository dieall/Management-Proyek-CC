<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DutySchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'committee_id',
        'duty_date',
        'start_time',
        'end_time',
        'location',
        'duty_type',
        'status',
        'remarks',
        'is_recurring',
        'recurring_type',
        'recurring_end_date',
    ];

    protected $casts = [
        'duty_date' => 'date',
        'recurring_end_date' => 'date',
        'is_recurring' => 'boolean',
    ];

    // Relasi ke Committee
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    // Scope untuk status
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope untuk duty type
    public function scopeType($query, $type)
    {
        return $query->where('duty_type', $type);
    }

    // Scope untuk tanggal
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('duty_date', [$start, $end]);
    }
}

