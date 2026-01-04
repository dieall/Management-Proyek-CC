<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'created_by',
        'nama_kegiatan',
        'jenis_kegiatan',
        'lokasi',
        'start_at',
        'end_at',
        'kuota',
        'start_time',
        'end_time',
        'status',
        'rule',
        'poster',
        'description',
        'attendees',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

