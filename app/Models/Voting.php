<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'committee_id',     // calon pengurus
        'position_id',      // jabatan yang diusulkan
        'start_date',
        'end_date',
        'status',           // open, closed, approved, rejected
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    // Aksesor hasil voting
    public function getResultAttribute(): string
    {
        if ($this->status !== 'closed') {
            return 'ongoing';
        }

        $yes = $this->votes()->where('vote', 'yes')->count();
        $no  = $this->votes()->where('vote', 'no')->count();

        if ($yes > $no) {
            return 'approved';
        } elseif ($no > $yes) {
            return 'rejected';
        } else {
            return 'tie';
        }
    }

    // accessor tambahan untuk hitung suara
    public function getYesCountAttribute(): int
    {
        return $this->votes()->where('vote', 'yes')->count();
    }

    public function getNoCountAttribute(): int
    {
        return $this->votes()->where('vote', 'no')->count();
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }
}
