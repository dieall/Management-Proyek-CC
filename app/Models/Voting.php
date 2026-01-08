<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'committee_id',
        'position_id',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relasi ke Committee (Kandidat)
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relasi ke Votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Helper method untuk hitung total suara
    public function totalVotes()
    {
        return $this->votes()->count();
    }

    public function yesVotes()
    {
        return $this->votes()->where('vote', 'yes')->count();
    }

    public function noVotes()
    {
        return $this->votes()->where('vote', 'no')->count();
    }

    // Scope untuk status
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}











