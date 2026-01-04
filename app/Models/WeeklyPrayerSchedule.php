<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyPrayerSchedule extends Model
{
    use HasFactory;

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

    // Get prayer time for specific day
    public function getTimeForDay($day)
    {
        $dayLower = strtolower($day);
        return $this->$dayLower ?? null;
    }

    // Get today's prayer time
    public function getTodayTime()
    {
        $today = strtolower(date('l')); // monday, tuesday, etc
        return $this->$today;
    }
}
