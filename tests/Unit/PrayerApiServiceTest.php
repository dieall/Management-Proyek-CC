<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\PrayerApiService;
use Carbon\Carbon;

class PrayerApiServiceTest extends TestCase
{
    public function test_get_weekly_schedule_parses_api_response()
    {
        // Fake a simple calendar response for December 2025 (only include relevant dates)
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

        Http::fake([
            '*' => Http::response(['data' => $fakeData], 200),
        ]);

        $service = new PrayerApiService();
        $week = $service->getWeeklySchedule(Carbon::create(2025, 12, 16, 12, 0, 0, 'Asia/Jakarta'));

        // Expecting rows for 5 prayers
        $this->assertCount(5, $week);

        // Check first row has monday..sunday keys and a time value
        $row = $week[0];
        $this->assertArrayHasKey('prayer_name', $row);
        $this->assertArrayHasKey('monday', $row);
        $this->assertNotNull($row['monday']);
        $this->assertMatchesRegularExpression('/^\d{1,2}:\d{2}$/', $row['monday']);
    }
}
