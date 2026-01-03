<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\WeeklyPrayerSchedule;

class SyncPrayerScheduleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_runs_and_outputs_messages()
    {
        $fakeData = [];
        for ($d = 14; $d <= 20; $d++) {
            $day = sprintf('%02d-12-2025', $d);
            $fakeData[] = [
                'date' => ['gregorian' => ['date' => $day]],
                'timings' => [
                    'Fajr' => '04:30 (WIB)',
                    'Dhuhr' => '11:45 (WIB)',
                    'Asr' => '15:00 (WIB)',
                    'Maghrib' => '17:55 (WIB)',
                    'Isha' => '19:10 (WIB)',
                ],
            ];
        }

        Http::fake(['*' => Http::response(['data' => $fakeData], 200)]);

        $this->artisan('prayer:sync')
            ->expectsOutput('Fetching weekly prayer schedule...')
            ->assertExitCode(0);

        // Ensure DB was updated for at least one prayer and time is normalized
        $this->assertDatabaseHas('weekly_prayer_schedules', [
            'prayer_name' => 'Subuh',
            'monday' => '04:30:00',
        ]);
    }
}
