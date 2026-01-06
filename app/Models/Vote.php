<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'voting_id',
        'committee_id',
        'vote',
        'comment',
    ];

    // Relasi ke Voting
    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }

    // Relasi ke Committee (Pemberi suara)
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}








