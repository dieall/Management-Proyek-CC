<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationalStructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'position_id',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'order',
        'is_division',
        'division_name',
        'division_description',
    ];

    protected $casts = [
        'lft' => 'integer',
        'rgt' => 'integer',
        'depth' => 'integer',
        'order' => 'integer',
        'is_division' => 'boolean',
    ];

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relasi ke Parent
    public function parent()
    {
        return $this->belongsTo(OrganizationalStructure::class, 'parent_id');
    }

    // Relasi ke Children
    public function children()
    {
        return $this->hasMany(OrganizationalStructure::class, 'parent_id')->orderBy('order');
    }

    // Scope untuk division
    public function scopeDivision($query)
    {
        return $query->where('is_division', true);
    }
}

