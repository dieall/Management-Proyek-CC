<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'committee_id',
        'position_id',
        'start_date',
        'end_date',
        'is_active',
        'appointment_type',
        'remarks',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi ke Committee
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Scope untuk riwayat aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}











