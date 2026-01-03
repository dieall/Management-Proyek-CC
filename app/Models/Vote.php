<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'voting_id',
        'committee_id',  // siapa yang memberikan suara
        'vote',          // yes atau no
        'comment',
    ];

    protected $casts = [
        'vote' => 'string',
    ];

    public function voting(): BelongsTo
    {
        return $this->belongsTo(Voting::class);
    }

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }
}
