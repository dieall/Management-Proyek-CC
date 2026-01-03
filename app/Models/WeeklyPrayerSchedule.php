<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPrayerSchedule extends Model
{
    protected $table = 'weekly_prayer_schedules';
    
    protected $fillable = [
        'prayer_name',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];
}
