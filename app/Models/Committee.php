<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Committee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'committees';

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
        'cv_path', // untuk upload CV
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date'  => 'date',
        'active_status' => 'string',
        'gender' => 'string',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function positionHistories(): HasMany
    {
        return $this->hasMany(PositionHistory::class);
    }

    public function dutySchedules(): HasMany
    {
        return $this->hasMany(DutySchedule::class);
    }

    public function taskAssignments(): HasMany
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function currentPositionHistory()
    {
        return $this->hasOne(PositionHistory::class)->where('is_active', true)->latest();
    }

    public function scopeActive($query)
    {
        return $query->where('active_status', 'active');
    }

    public function scopeByPosition($query, $positionId)
    {
        return $query->where('position_id', $positionId);
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->diffInYears(now()) : null;
    }

    public function getTenureAttribute(): ?int
    {
        return $this->join_date ? Carbon::parse($this->join_date)->diffInYears(now()) : null;
    }
}
