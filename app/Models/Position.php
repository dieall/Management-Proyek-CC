<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'status',
        'level',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Relasi ke parent position
    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    // Relasi ke child positions
    public function children()
    {
        return $this->hasMany(Position::class, 'parent_id')->orderBy('order');
    }

    // Relasi ke committees
    public function committees()
    {
        return $this->hasMany(Committee::class);
    }

    // Relasi ke position histories
    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class);
    }

    // Relasi ke job responsibilities
    public function jobResponsibilities()
    {
        return $this->hasMany(JobResponsibility::class);
    }

    // Relasi ke organizational structures
    public function organizationalStructure()
    {
        return $this->hasOne(OrganizationalStructure::class);
    }

    // Scope untuk status aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk level
    public function scopeLeadership($query)
    {
        return $query->where('level', 'leadership');
    }

    public function scopeMember($query)
    {
        return $query->where('level', 'member');
    }

    public function scopeStaff($query)
    {
        return $query->where('level', 'staff');
    }
}











